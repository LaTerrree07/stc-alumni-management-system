<x-app-layout>
    @php
        $routePrefix = auth()->user()->role === 'admin' ? 'admin' : 'alumni';

        $typeClasses = [
            'job_post' => 'bg-blue-50 text-blue-700 border-blue-200',
            'event' => 'bg-purple-50 text-purple-700 border-purple-200',
            'donation' => 'bg-green-50 text-green-700 border-green-200',
            'announcement' => 'bg-[#6B0F1A]/10 text-[#6B0F1A] border-[#6B0F1A]/20',
        ];
    @endphp

    <div class="space-y-6">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    Notifications
                </h1>

                <p class="mt-1 text-sm text-gray-600">
                    View system updates, approvals, submissions, and announcements.
                </p>
            </div>

            @if ($unreadCount > 0)
                <form method="POST" action="{{ route($routePrefix . '.notifications.read-all') }}">
                    @csrf
                    @method('PATCH')

                    <button
                        type="submit"
                        class="rounded-lg bg-[#6B0F1A] px-4 py-2 text-sm font-semibold text-white hover:bg-[#4A0A12]"
                        data-confirm
                        data-confirm-title="Mark All as Read"
                        data-confirm-message="Are you sure you want to mark all notifications as read?"
                        data-confirm-text="Mark All"
                        data-confirm-variant="primary"
                        data-confirm-icon="neutral"
                    >
                        Mark All as Read
                    </button>
                </form>
            @endif
        </div>

        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
            <x-summary-card
                title="Unread Notifications"
                value="{{ $unreadCount }}"
                variant="warning"
            />

            <x-summary-card
                title="Read Notifications"
                value="{{ $readCount }}"
                variant="neutral"
            />
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <form method="GET" action="{{ route($routePrefix . '.notifications.index') }}" class="flex flex-col gap-3 sm:flex-row">
                <select
                    name="status"
                    class="rounded-lg border-gray-300 shadow-sm focus:border-[#6B0F1A] focus:ring-[#6B0F1A]"
                >
                    <option value="">All Notifications</option>
                    <option value="unread" @selected($status === 'unread')>Unread</option>
                    <option value="read" @selected($status === 'read')>Read</option>
                </select>

                <button
                    type="submit"
                    class="rounded-lg bg-[#6B0F1A] px-4 py-2 text-sm font-semibold text-white hover:bg-[#4A0A12]"
                >
                    Filter
                </button>

                @if ($status)
                    <a
                        href="{{ route($routePrefix . '.notifications.index') }}"
                        class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-center text-sm font-semibold text-gray-700 hover:bg-gray-50"
                    >
                        Clear
                    </a>
                @endif
            </form>
        </div>

        <div class="space-y-3">
            @forelse ($notifications as $notification)
                <div class="rounded-xl border {{ $notification->status === 'unread' ? 'border-[#6B0F1A]/30 bg-white' : 'border-gray-200 bg-white' }} p-5 shadow-sm">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                        <div class="flex-1">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="rounded-full border px-3 py-1 text-xs font-semibold {{ $typeClasses[$notification->type] ?? 'bg-gray-50 text-gray-700 border-gray-200' }}">
                                    {{ $notification->type ? ucwords(str_replace('_', ' ', $notification->type)) : 'System' }}
                                </span>

                                <span class="rounded-full border px-3 py-1 text-xs font-semibold {{ $notification->status === 'unread' ? 'bg-amber-50 text-amber-700 border-amber-200' : 'bg-gray-100 text-gray-600 border-gray-200' }}">
                                    {{ ucfirst($notification->status) }}
                                </span>
                            </div>

                            <p class="mt-3 text-sm leading-relaxed text-gray-800">
                                {{ $notification->message }}
                            </p>

                            <p class="mt-2 text-xs text-gray-500">
                                {{ \App\Support\DateTimeFormatter::dateWithTime($notification->created_at) }}
                            </p>
                        </div>

                        @if ($notification->status === 'unread')
                            <form method="POST" action="{{ route($routePrefix . '.notifications.read', $notification) }}">
                                @csrf
                                @method('PATCH')

                                <x-action-icon
                                    type="button"
                                    icon="check"
                                    label="Mark as read"
                                    variant="approve"
                                    data-confirm
                                    data-confirm-title="Mark as Read"
                                    data-confirm-message="Are you sure you want to mark this notification as read?"
                                    data-confirm-text="Mark as Read"
                                    data-confirm-variant="success"
                                    data-confirm-icon="success"
                                />
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="rounded-xl border border-gray-200 bg-white p-10 text-center shadow-sm">
                    <h2 class="text-base font-semibold text-gray-900">
                        No notifications found.
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        System notifications will appear here when there are updates.
                    </p>
                </div>
            @endforelse
        </div>

        @if ($notifications->hasPages())
            <div>
                {{ $notifications->links() }}
            </div>
        @endif
    </div>
</x-app-layout>