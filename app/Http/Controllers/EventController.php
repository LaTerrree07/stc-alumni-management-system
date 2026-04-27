<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Services\NotificationService;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $query = Event::query()
            ->with(['creator', 'reviewer']);

        if (auth()->user()->role === 'alumni') {
            $query->where(function ($eventQuery) {
                $eventQuery
                    ->where('status', 'approved')
                    ->orWhere('user_id', auth()->id());
            });
        }

        $events = $query
            ->when($search, function ($query, $search) {
                $query->where(function ($eventQuery) use ($search) {
                    $eventQuery
                        ->where('event_title', 'like', "%{$search}%")
                        ->orWhere('location', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->when($status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->latest('event_id')
            ->paginate(10)
            ->withQueryString();

        return view('events.index', compact('events', 'search', 'status'));
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(StoreEventRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('event_image')) {
            $validated['event_image'] = $request->file('event_image')
                ->store('event-images', 'public');
        }

        $isAdmin = auth()->user()->role === 'admin';

        $event = Event::create([
    ...$validated,
    'user_id' => auth()->id(),
    'status' => $isAdmin ? 'approved' : 'pending',
    'reviewed_by' => $isAdmin ? auth()->id() : null,
    'reviewed_at' => $isAdmin ? now() : null,
]);

if (! $isAdmin) {
    app(NotificationService::class)->notifyAdmins(
        auth()->user()->full_name . ' submitted an event for approval.',
        'event',
        'events',
        $event->event_id
    );
}

        return redirect()
            ->route($this->routePrefix() . '.events.index')
            ->with('success', $isAdmin
                ? 'Event created and approved successfully.'
                : 'Event submitted successfully. It is now pending admin approval.'
            );
    }

    public function show(Event $event)
    {
        $this->authorizeView($event);

        $event->load(['creator', 'reviewer']);

        return view('events.show', compact('event'));
    }

    public function edit(Event $event)
    {
        $this->authorizeEdit($event);

        return view('events.edit', compact('event'));
    }

    public function update(UpdateEventRequest $request, Event $event)
    {
        $this->authorizeEdit($event);

        $validated = $request->validated();

        if ($request->hasFile('event_image')) {
            if ($event->event_image) {
                Storage::disk('public')->delete($event->event_image);
            }

            $validated['event_image'] = $request->file('event_image')
                ->store('event-images', 'public');
        }

        if (auth()->user()->role === 'alumni') {
            $validated['status'] = 'pending';
            $validated['reviewed_by'] = null;
            $validated['reviewed_at'] = null;
            $validated['admin_note'] = null;
        }

        $event->update($validated);

        return redirect()
            ->route($this->routePrefix() . '.events.index')
            ->with('success', auth()->user()->role === 'alumni'
                ? 'Event updated and resubmitted for approval.'
                : 'Event updated successfully.'
            );
    }

    public function approve(Event $event)
    {
        abort_if(auth()->user()->role !== 'admin', 403);

        $event->update([
            'status' => 'approved',
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
            'admin_note' => null,
        ]);

        app(NotificationService::class)->create(
    $event->user_id,
    'Your event "' . $event->event_title . '" has been approved.',
    'event',
    'events',
    $event->event_id
);

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Event approved successfully.');
    }

    public function reject(Request $request, Event $event)
    {
        abort_if(auth()->user()->role !== 'admin', 403);

        $validated = $request->validate([
            'admin_note' => ['required', 'string', 'max:1000'],
        ]);

        $event->update([
            'status' => 'rejected',
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
            'admin_note' => $validated['admin_note'],
        ]);

        app(NotificationService::class)->create(
    $event->user_id,
    'Your event "' . $event->event_title . '" has been rejected. Reason: ' . $validated['admin_note'],
    'event',
    'events',
    $event->event_id
);

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Event rejected successfully.');
    }

    public function complete(Event $event)
    {
        abort_if(auth()->user()->role !== 'admin', 403);

        $event->update([
            'status' => 'completed',
        ]);

        app(NotificationService::class)->create(
    $event->user_id,
    'Your event "' . $event->event_title . '" has been marked as completed.',
    'event',
    'events',
    $event->event_id
);

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Event marked as completed successfully.');
    }

    public function cancel(Request $request, Event $event)
    {
        abort_if(auth()->user()->role !== 'admin', 403);

        $validated = $request->validate([
            'admin_note' => ['required', 'string', 'max:1000'],
        ]);

        $event->update([
            'status' => 'cancelled',
            'admin_note' => $validated['admin_note'],
        ]);

        app(NotificationService::class)->create(
    $event->user_id,
    'Your event "' . $event->event_title . '" has been cancelled. Reason: ' . $validated['admin_note'],
    'event',
    'events',
    $event->event_id
);

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Event cancelled successfully.');
    }

    public function archive(Event $event)
    {
        abort_if(auth()->user()->role !== 'admin', 403);

        $event->update([
            'status' => 'archived',
        ]);

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Event archived successfully.');
    }

    private function authorizeView(Event $event): void
    {
        if (auth()->user()->role === 'admin') {
            return;
        }

        if ($event->status === 'approved' || $event->user_id === auth()->id()) {
            return;
        }

        abort(403);
    }

    private function authorizeEdit(Event $event): void
    {
        if (auth()->user()->role === 'admin') {
            return;
        }

        if ($event->user_id === auth()->id() && in_array($event->status, ['pending', 'rejected'])) {
            return;
        }

        abort(403);
    }

    private function routePrefix(): string
    {
        return auth()->user()->role === 'admin' ? 'admin' : 'alumni';
    }
}