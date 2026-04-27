<x-app-layout>
    @php
        $routePrefix = auth()->user()->role === 'admin' ? 'admin' : 'alumni';

        $statusClasses = [
            'pending' => 'bg-amber-50 text-amber-700 border-amber-200',
            'approved' => 'bg-green-50 text-green-700 border-green-200',
            'rejected' => 'bg-red-50 text-red-700 border-red-200',
            'completed' => 'bg-green-50 text-green-700 border-green-200',
            'cancelled' => 'bg-red-50 text-red-700 border-red-200',
            'archived' => 'bg-gray-100 text-gray-700 border-gray-200',
        ];
    @endphp

    <div class="space-y-6">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    Events
                </h1>

                <p class="mt-1 text-sm text-gray-600">
                    View and manage alumni events and event proposals.
                </p>
            </div>

            <a
                href="{{ route($routePrefix . '.events.create') }}"
                class="inline-flex items-center justify-center rounded-lg bg-[#6B0F1A] px-4 py-2 text-sm font-semibold text-white hover:bg-[#4A0A12]"
            >
                Add Event
            </a>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <form method="GET" action="{{ route($routePrefix . '.events.index') }}" class="space-y-4">
                <input
                    type="text"
                    name="search"
                    value="{{ $search }}"
                    placeholder="Search by event title, location, or description..."
                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#6B0F1A] focus:ring-[#6B0F1A]"
                >

                <div class="flex flex-col gap-3 sm:flex-row">
                    <select
                        name="status"
                        class="rounded-lg border-gray-300 shadow-sm focus:border-[#6B0F1A] focus:ring-[#6B0F1A]"
                    >
                        <option value="">All Status</option>
                        <option value="pending" @selected($status === 'pending')>Pending</option>
                        <option value="approved" @selected($status === 'approved')>Approved</option>
                        <option value="rejected" @selected($status === 'rejected')>Rejected</option>
                        <option value="completed" @selected($status === 'completed')>Completed</option>
                        <option value="cancelled" @selected($status === 'cancelled')>Cancelled</option>
                        <option value="archived" @selected($status === 'archived')>Archived</option>
                    </select>

                    <button
                        type="submit"
                        class="rounded-lg bg-[#6B0F1A] px-4 py-2 text-sm font-semibold text-white hover:bg-[#4A0A12]"
                    >
                        Filter
                    </button>

                    @if ($search || $status)
                        <a
                            href="{{ route($routePrefix . '.events.index') }}"
                            class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-center text-sm font-semibold text-gray-700 hover:bg-gray-50"
                        >
                            Clear
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Event</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Schedule</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Submitted By</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse ($events as $event)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="h-12 w-16 overflow-hidden rounded-lg bg-gray-100 border border-gray-200">
                                            @if ($event->event_image)
                                                <img
                                                    src="{{ asset('storage/' . $event->event_image) }}"
                                                    alt="{{ $event->event_title }}"
                                                    class="h-full w-full object-cover"
                                                >
                                            @else
                                                <div class="flex h-full w-full items-center justify-center text-xs text-gray-400">
                                                    No Image
                                                </div>
                                            @endif
                                        </div>

                                        <div>
                                            <p class="font-semibold text-gray-900">{{ $event->event_title }}</p>
                                            <p class="text-sm text-gray-500">{{ $event->location ?? 'Location not provided' }}</p>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-sm text-gray-700">
                                   <p>{{ \App\Support\DateTimeFormatter::dateOnly($event->event_date) }}</p>
<p class="text-xs text-gray-500">
    {{ \App\Support\DateTimeFormatter::time12Hour($event->event_time) }}
</p>
                                </td>

                                <td class="px-6 py-4 text-sm text-gray-700">
                                    {{ $event->creator->full_name ?? 'Unknown' }}
                                </td>

                                <td class="px-6 py-4">
                                    <span class="rounded-full border px-3 py-1 text-xs font-semibold {{ $statusClasses[$event->status] ?? 'bg-gray-100 text-gray-700 border-gray-200' }}">
                                        {{ ucfirst($event->status) }}
                                    </span>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex justify-end gap-2">
                                        <x-action-icon
                                            :href="route($routePrefix . '.events.show', $event)"
                                            icon="eye"
                                            label="View event"
                                            variant="view"
                                        />

                                        @if (auth()->user()->role === 'admin' || ($event->user_id === auth()->id() && in_array($event->status, ['pending', 'rejected'])))
                                            <x-action-icon
                                                :href="route($routePrefix . '.events.edit', $event)"
                                                icon="pencil"
                                                label="Edit event"
                                                variant="edit"
                                            />
                                        @endif

                                        @if (auth()->user()->role === 'admin')
                                            @if ($event->status === 'pending')
                                                <form method="POST" action="{{ route('admin.events.approve', $event) }}">
                                                    @csrf
                                                    @method('PATCH')

                                                    <x-action-icon
                                                        type="button"
                                                        icon="check"
                                                        label="Approve event"
                                                        variant="approve"
                                                        data-confirm
                                                        data-confirm-title="Approve Event"
                                                        data-confirm-message="Are you sure you want to approve this event? Once approved, it will be visible to alumni."
                                                        data-confirm-text="Approve"
                                                        data-confirm-variant="success"
                                                        data-confirm-icon="success"
                                                    />
                                                </form>
                                            @endif

                                            @if ($event->status === 'approved')
                                                <form method="POST" action="{{ route('admin.events.complete', $event) }}">
                                                    @csrf
                                                    @method('PATCH')

                                                    <x-action-icon
                                                        type="button"
                                                        icon="check"
                                                        label="Mark as completed"
                                                        variant="approve"
                                                        data-confirm
                                                        data-confirm-title="Complete Event"
                                                        data-confirm-message="Are you sure you want to mark this event as completed?"
                                                        data-confirm-text="Complete"
                                                        data-confirm-variant="success"
                                                        data-confirm-icon="success"
                                                    />
                                                </form>
                                            @endif

                                            @if (! in_array($event->status, ['archived', 'cancelled']))
                                                <form method="POST" action="{{ route('admin.events.archive', $event) }}">
                                                    @csrf
                                                    @method('PATCH')

                                                    <x-action-icon
                                                        type="button"
                                                        icon="archive"
                                                        label="Archive event"
                                                        variant="archive"
                                                        data-confirm
                                                        data-confirm-title="Archive Event"
                                                        data-confirm-message="Are you sure you want to archive this event?"
                                                        data-confirm-text="Archive"
                                                        data-confirm-variant="neutral"
                                                        data-confirm-icon="warning"
                                                    />
                                                </form>
                                            @endif
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <p class="text-sm font-medium text-gray-900">No events found.</p>
                                    <p class="mt-1 text-sm text-gray-500">Events will appear here once created.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($events->hasPages())
                <div class="border-t border-gray-100 px-6 py-4">
                    {{ $events->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>