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

    <div class="mx-auto max-w-5xl space-y-6">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    {{ $event->event_title }}
                </h1>

                <p class="mt-1 text-sm text-gray-600">
                    Event details and review information.
                </p>
            </div>

            <a
                href="{{ route($routePrefix . '.events.index') }}"
                class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50"
            >
                Back
            </a>
        </div>

        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            @if ($event->event_image)
                <img
                    src="{{ asset('storage/' . $event->event_image) }}"
                    alt="{{ $event->event_title }}"
                    class="h-72 w-full object-cover"
                >
            @endif

            <div class="p-6">
                <div class="flex flex-wrap gap-2">
                    <span class="rounded-full border px-3 py-1 text-xs font-semibold {{ $statusClasses[$event->status] ?? 'bg-gray-100 text-gray-700 border-gray-200' }}">
                        {{ ucfirst($event->status) }}
                    </span>

                    <span class="rounded-full border border-gray-200 bg-gray-50 px-3 py-1 text-xs font-semibold text-gray-700">
    {{ \App\Support\DateTimeFormatter::dateOnly($event->event_date) }}
</span>

@if ($event->event_time)
    <span class="rounded-full border border-gray-200 bg-gray-50 px-3 py-1 text-xs font-semibold text-gray-700">
        {{ \App\Support\DateTimeFormatter::time12Hour($event->event_time) }}
    </span>
@endif
                </div>

                <div class="mt-6 grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Location</p>
                        <p class="mt-1 text-sm text-gray-900">{{ $event->location ?? 'Not provided' }}</p>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-gray-500">Submitted By</p>
                        <p class="mt-1 text-sm text-gray-900">{{ $event->creator->full_name ?? 'Unknown' }}</p>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-gray-500">Budget Used</p>
                        <p class="mt-1 text-sm text-gray-900">
                            {{ $event->budget_used ? '₱' . number_format($event->budget_used, 2) : 'Not provided' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-gray-500">Reviewed By</p>
                        <p class="mt-1 text-sm text-gray-900">
                            {{ $event->reviewer->full_name ?? 'Not reviewed yet' }}
                        </p>
                    </div>
                </div>

                <div class="mt-6">
                    <h2 class="text-lg font-bold text-gray-900">Description</h2>
                    <p class="mt-2 whitespace-pre-line text-sm leading-relaxed text-gray-700">
                        {{ $event->description }}
                    </p>
                </div>

                @if ($event->admin_note)
                    <div class="mt-6 rounded-lg border border-red-200 bg-red-50 p-4">
                        <p class="text-sm font-semibold text-red-700">Admin Note</p>
                        <p class="mt-1 text-sm text-red-700">{{ $event->admin_note }}</p>
                    </div>
                @endif
            </div>
        </div>

        @if (auth()->user()->role === 'admin')
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-bold text-gray-900">Event Actions</h2>

                <div class="mt-4 flex flex-wrap gap-3">
                    @if ($event->status === 'pending')
                        <form method="POST" action="{{ route('admin.events.approve', $event) }}">
                            @csrf
                            @method('PATCH')

                            <button
                                type="submit"
                                class="rounded-lg bg-green-600 px-4 py-2 text-sm font-semibold text-white hover:bg-green-700"
                                data-confirm
                                data-confirm-title="Approve Event"
                                data-confirm-message="Are you sure you want to approve this event?"
                                data-confirm-text="Approve"
                                data-confirm-variant="success"
                                data-confirm-icon="success"
                            >
                                Approve
                            </button>
                        </form>

                        <form method="POST" action="{{ route('admin.events.reject', $event) }}">
                            @csrf
                            @method('PATCH')

                            <button
                                type="submit"
                                class="rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700"
                                data-confirm
                                data-confirm-title="Reject Event"
                                data-confirm-message="Please provide a reason for rejecting this event."
                                data-confirm-text="Reject"
                                data-confirm-variant="danger"
                                data-confirm-icon="danger"
                                data-confirm-require-reason="true"
                            >
                                Reject
                            </button>
                        </form>
                    @endif

                    @if ($event->status === 'approved')
                        <form method="POST" action="{{ route('admin.events.complete', $event) }}">
                            @csrf
                            @method('PATCH')

                            <button
                                type="submit"
                                class="rounded-lg bg-green-600 px-4 py-2 text-sm font-semibold text-white hover:bg-green-700"
                                data-confirm
                                data-confirm-title="Complete Event"
                                data-confirm-message="Are you sure you want to mark this event as completed?"
                                data-confirm-text="Complete"
                                data-confirm-variant="success"
                                data-confirm-icon="success"
                            >
                                Complete
                            </button>
                        </form>

                        <form method="POST" action="{{ route('admin.events.cancel', $event) }}">
                            @csrf
                            @method('PATCH')

                            <button
                                type="submit"
                                class="rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700"
                                data-confirm
                                data-confirm-title="Cancel Event"
                                data-confirm-message="Please provide a reason for cancelling this event."
                                data-confirm-text="Cancel Event"
                                data-confirm-variant="danger"
                                data-confirm-icon="danger"
                                data-confirm-require-reason="true"
                            >
                                Cancel Event
                            </button>
                        </form>
                    @endif

                    @if (! in_array($event->status, ['archived', 'cancelled']))
                        <form method="POST" action="{{ route('admin.events.archive', $event) }}">
                            @csrf
                            @method('PATCH')

                            <button
                                type="submit"
                                class="rounded-lg bg-gray-700 px-4 py-2 text-sm font-semibold text-white hover:bg-gray-800"
                                data-confirm
                                data-confirm-title="Archive Event"
                                data-confirm-message="Are you sure you want to archive this event?"
                                data-confirm-text="Archive"
                                data-confirm-variant="neutral"
                                data-confirm-icon="warning"
                            >
                                Archive
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        @endif
    </div>
</x-app-layout>