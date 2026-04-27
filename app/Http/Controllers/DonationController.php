<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDonationRequest;
use App\Http\Requests\UpdateDonationRequest;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Services\NotificationService;

class DonationController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');
        $paymentType = $request->input('payment_type');

        $query = Donation::query()
            ->with(['creator', 'verifier']);

        if (auth()->user()->role === 'alumni') {
            $query->where('user_id', auth()->id());
        }

        $donations = $query
            ->when($search, function ($query, $search) {
                $query->where(function ($donationQuery) use ($search) {
                    $donationQuery
                        ->where('donor_name', 'like', "%{$search}%")
                        ->orWhere('reference_details', 'like', "%{$search}%")
                        ->orWhere('purpose', 'like', "%{$search}%")
                        ->orWhere('payment_method', 'like', "%{$search}%");
                });
            })
            ->when($status, fn ($query) => $query->where('status', $status))
            ->when($paymentType, fn ($query) => $query->where('payment_type', $paymentType))
            ->latest('donation_id')
            ->paginate(10)
            ->withQueryString();

        $totalVerifiedDonations = Donation::query()
            ->where('status', 'verified')
            ->sum('amount');

        $pendingDonations = Donation::query()
            ->where('status', 'pending')
            ->count();

        $verifiedDonations = Donation::query()
            ->where('status', 'verified')
            ->count();

        return view('donations.index', compact(
            'donations',
            'search',
            'status',
            'paymentType',
            'totalVerifiedDonations',
            'pendingDonations',
            'verifiedDonations'
        ));
    }

    public function create()
    {
        return view('donations.create');
    }

    public function store(StoreDonationRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('proof_of_payment')) {
            $validated['proof_of_payment'] = $request->file('proof_of_payment')
                ->store('proof-of-payments', 'public');
        }

        $isAdmin = auth()->user()->role === 'admin';

       $donation = Donation::create([
    ...$validated,
    'user_id' => auth()->id(),
    'status' => $isAdmin ? 'verified' : 'pending',
    'verified_by' => $isAdmin ? auth()->id() : null,
    'verified_at' => $isAdmin ? now() : null,
]);

if (! $isAdmin) {
    app(NotificationService::class)->notifyAdmins(
        auth()->user()->full_name . ' submitted a donation for verification.',
        'donation',
        'donations',
        $donation->donation_id
    );
}

        return redirect()
            ->route($this->routePrefix() . '.donations.index')
            ->with('success', $isAdmin
                ? 'Donation recorded and verified successfully.'
                : 'Donation submitted successfully. It is now pending admin verification.'
            );
    }

    public function show(Donation $donation)
    {
        $this->authorizeView($donation);

        $donation->load(['creator', 'verifier']);

        return view('donations.show', compact('donation'));
    }

    public function edit(Donation $donation)
    {
        $this->authorizeEdit($donation);

        return view('donations.edit', compact('donation'));
    }

    public function update(UpdateDonationRequest $request, Donation $donation)
    {
        $this->authorizeEdit($donation);

        $validated = $request->validated();

        if ($request->hasFile('proof_of_payment')) {
            if ($donation->proof_of_payment) {
                Storage::disk('public')->delete($donation->proof_of_payment);
            }

            $validated['proof_of_payment'] = $request->file('proof_of_payment')
                ->store('proof-of-payments', 'public');
        }

        if (auth()->user()->role === 'alumni') {
            $validated['status'] = 'pending';
            $validated['verified_by'] = null;
            $validated['verified_at'] = null;
            $validated['admin_note'] = null;
        }

        $donation->update($validated);

        return redirect()
            ->route($this->routePrefix() . '.donations.index')
            ->with('success', auth()->user()->role === 'alumni'
                ? 'Donation updated and resubmitted for verification.'
                : 'Donation updated successfully.'
            );
    }

    public function verify(Donation $donation)
    {
        abort_if(auth()->user()->role !== 'admin', 403);

        $donation->update([
            'status' => 'verified',
            'verified_by' => auth()->id(),
            'verified_at' => now(),
            'admin_note' => null,
        ]);

        app(NotificationService::class)->create(
    $donation->user_id,
    'Your donation of ₱' . number_format($donation->amount, 2) . ' has been verified.',
    'donation',
    'donations',
    $donation->donation_id
);

        return redirect()
            ->route('admin.donations.index')
            ->with('success', 'Donation verified successfully.');
    }

    public function reject(Request $request, Donation $donation)
    {
        abort_if(auth()->user()->role !== 'admin', 403);

        $validated = $request->validate([
            'admin_note' => ['required', 'string', 'max:1000'],
        ]);

        $donation->update([
            'status' => 'rejected',
            'verified_by' => auth()->id(),
            'verified_at' => now(),
            'admin_note' => $validated['admin_note'],
        ]);

        app(NotificationService::class)->create(
    $donation->user_id,
    'Your donation of ₱' . number_format($donation->amount, 2) . ' has been rejected. Reason: ' . $validated['admin_note'],
    'donation',
    'donations',
    $donation->donation_id
);


        return redirect()
            ->route('admin.donations.index')
            ->with('success', 'Donation rejected successfully.');
    }

    public function archive(Donation $donation)
    {
        abort_if(auth()->user()->role !== 'admin', 403);

        $donation->update([
            'status' => 'archived',
        ]);

        return redirect()
            ->route('admin.donations.index')
            ->with('success', 'Donation archived successfully.');
    }

    private function authorizeView(Donation $donation): void
    {
        if (auth()->user()->role === 'admin') {
            return;
        }

        if ($donation->user_id === auth()->id()) {
            return;
        }

        abort(403);
    }

    private function authorizeEdit(Donation $donation): void
    {
        if (auth()->user()->role === 'admin') {
            return;
        }

        if ($donation->user_id === auth()->id() && in_array($donation->status, ['pending', 'rejected'])) {
            return;
        }

        abort(403);
    }

    private function routePrefix(): string
    {
        return auth()->user()->role === 'admin' ? 'admin' : 'alumni';
    }
}