<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Event;
use App\Models\EventFund;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class EventFundController extends Controller
{
    public function index(Request $request)
    {
        $selectedYear = $request->input('year', now()->year);

        $availableVerifiedDonations = $this->getAvailableVerifiedDonationBalance();

        $eventFund = EventFund::query()
            ->where('fund_year', $selectedYear)
            ->first();

        if ($eventFund) {
            $this->syncFundUsage($eventFund);
        }

        $eventFunds = EventFund::query()
            ->latest('fund_year')
            ->paginate(10)
            ->withQueryString();

        $years = EventFund::query()
            ->select('fund_year')
            ->distinct()
            ->orderByDesc('fund_year')
            ->pluck('fund_year');

        return view('event-funds.index', compact(
            'eventFund',
            'eventFunds',
            'years',
            'selectedYear',
            'availableVerifiedDonations'
        ));
    }

    public function store(Request $request)
    {
        abort_if(auth()->user()->role !== 'admin', 403);

        $validated = $request->validate([
            'fund_year' => ['required', 'integer', 'min:2000', 'max:' . (now()->year + 5), 'unique:event_funds,fund_year'],
            'total_fund' => ['required', 'numeric', 'min:0'],
        ]);

        $availableVerifiedDonations = $this->getAvailableVerifiedDonationBalance();
        $usedFund = $this->getUsedFundForYear($validated['fund_year']);

        if ($validated['total_fund'] > $availableVerifiedDonations) {
            throw ValidationException::withMessages([
                'total_fund' => 'The total event fund cannot exceed the available verified donation balance.',
            ]);
        }

        if ($validated['total_fund'] < $usedFund) {
            throw ValidationException::withMessages([
                'total_fund' => 'The total event fund cannot be lower than the used event fund for this year.',
            ]);
        }

        $remainingFund = $validated['total_fund'] - $usedFund;

        EventFund::create([
            'fund_year' => $validated['fund_year'],
            'total_fund' => $validated['total_fund'],
            'used_fund' => $usedFund,
            'remaining_fund' => $remainingFund,
            'created_by' => auth()->id(),
        ]);

        return redirect()
            ->route('admin.event-funds.index', ['year' => $validated['fund_year']])
            ->with('success', 'Event fund created successfully.');
    }

    public function update(Request $request, EventFund $eventFund)
    {
        abort_if(auth()->user()->role !== 'admin', 403);

        $validated = $request->validate([
            'total_fund' => ['required', 'numeric', 'min:0'],
        ]);

        $availableVerifiedDonations = $this->getAvailableVerifiedDonationBalance();
        $usedFund = $this->getUsedFundForYear($eventFund->fund_year);

        if ($validated['total_fund'] > $availableVerifiedDonations) {
            throw ValidationException::withMessages([
                'total_fund' => 'The total event fund cannot exceed the available verified donation balance.',
            ]);
        }

        if ($validated['total_fund'] < $usedFund) {
            throw ValidationException::withMessages([
                'total_fund' => 'The total event fund cannot be lower than the used event fund for this year.',
            ]);
        }

        $remainingFund = $validated['total_fund'] - $usedFund;

        $eventFund->update([
            'total_fund' => $validated['total_fund'],
            'used_fund' => $usedFund,
            'remaining_fund' => $remainingFund,
        ]);

        return redirect()
            ->route('admin.event-funds.index', ['year' => $eventFund->fund_year])
            ->with('success', 'Event fund updated successfully.');
    }

    private function syncFundUsage(EventFund $eventFund): void
    {
        $usedFund = $this->getUsedFundForYear($eventFund->fund_year);

        $remainingFund = max($eventFund->total_fund - $usedFund, 0);

        $eventFund->update([
            'used_fund' => $usedFund,
            'remaining_fund' => $remainingFund,
        ]);
    }

    private function getUsedFundForYear(int $year): float
    {
        return (float) Event::query()
            ->whereYear('event_date', $year)
            ->whereIn('status', ['approved', 'completed'])
            ->sum('budget_used');
    }

    private function getAvailableVerifiedDonationBalance(): float
    {
        return (float) Donation::query()
            ->where('status', 'verified')
            ->sum('amount');
    }
}