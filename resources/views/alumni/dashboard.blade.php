<x-app-layout>
    @php
        $statusColors = [
            'pending' => 'bg-amber-50 text-amber-700 border-amber-200',
            'approved' => 'bg-green-50 text-green-700 border-green-200',
            'verified' => 'bg-green-50 text-green-700 border-green-200',
            'published' => 'bg-green-50 text-green-700 border-green-200',
            'rejected' => 'bg-red-50 text-red-700 border-red-200',
            'archived' => 'bg-gray-100 text-gray-700 border-gray-200',
            'completed' => 'bg-green-50 text-green-700 border-green-200',
            'cancelled' => 'bg-red-50 text-red-700 border-red-200',
        ];
    @endphp

    <div class="space-y-6">
        <!-- Page Header -->
        <div>
            <h1 class="text-2xl font-bold text-gray-900">
                Alumni Dashboard
            </h1>

            <p class="mt-1 text-sm text-gray-600">
                View your submissions, opportunities, events, donations, announcements, and notifications.
            </p>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-5">
            <x-summary-card
                title="My Submitted Job Posts"
                value="{{ $summary['mySubmittedJobPosts'] }}"
                variant="primary"
                :href="route('alumni.job-posts.index')"
            />

            <x-summary-card
                title="My Pending Job Posts"
                value="{{ $summary['myPendingJobPosts'] }}"
                variant="warning"
                :href="route('alumni.job-posts.index', ['status' => 'pending'])"
            />

            <x-summary-card
                title="Available Job Posts"
                value="{{ $summary['availableApprovedJobPosts'] }}"
                variant="success"
                :href="route('alumni.job-posts.index', ['status' => 'approved'])"
            />

            <x-summary-card
                title="Upcoming Events"
                value="{{ $summary['upcomingApprovedEvents'] }}"
                variant="success"
                :href="route('alumni.events.index', ['status' => 'approved'])"
            />

            <x-summary-card
                title="My Submitted Events"
                value="{{ $summary['mySubmittedEvents'] }}"
                variant="primary"
                :href="route('alumni.events.index')"
            />

            <x-summary-card
                title="My Donations"
                value="{{ $summary['myDonations'] }}"
                variant="primary"
                :href="route('alumni.donations.index')"
            />

            <x-summary-card
                title="My Pending Donations"
                value="{{ $summary['myPendingDonations'] }}"
                variant="warning"
                :href="route('alumni.donations.index', ['status' => 'pending'])"
            />

            <x-summary-card
                title="My Verified Donations"
                value="₱{{ number_format($summary['myVerifiedDonations'], 2) }}"
                variant="success"
                :href="route('alumni.donations.index', ['status' => 'verified'])"
            />

            <x-summary-card
                title="Published Announcements"
                value="{{ $summary['publishedAnnouncements'] }}"
                variant="success"
                :href="route('alumni.announcements.index')"
            />

            <x-summary-card
                title="Unread Notifications"
                value="{{ $summary['unreadNotifications'] }}"
                variant="warning"
                :href="route('alumni.notifications.index', ['status' => 'unread'])"
            />
        </div>

        <!-- Recent Sections -->
        <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
            <!-- Latest Approved Job Posts -->
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">
                            Latest Approved Job Posts
                        </h2>

                        <p class="mt-1 text-sm text-gray-500">
                            Recently approved job opportunities available to alumni.
                        </p>
                    </div>

                    <a
                        href="{{ route('alumni.job-posts.index', ['status' => 'approved']) }}"
                        class="text-sm font-semibold text-[#6B0F1A] hover:underline"
                    >
                        View all
                    </a>
                </div>

                <div class="mt-4 space-y-3">
                    @forelse ($recent['jobPosts'] as $jobPost)
                        <div class="rounded-lg border border-gray-100 p-3">
                            <p class="truncate text-sm font-semibold text-gray-900">
                                {{ $jobPost->job_title }}
                            </p>

                            <p class="truncate text-xs text-gray-500">
                                {{ $jobPost->company_name }}
                            </p>
                        </div>
                    @empty
                        <div class="rounded-lg border border-dashed border-gray-200 bg-gray-50 p-6 text-center">
                            <p class="text-sm text-gray-500">
                                No approved job posts yet.
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Upcoming Events -->
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">
                            Upcoming Events
                        </h2>

                        <p class="mt-1 text-sm text-gray-500">
                            Approved upcoming alumni events.
                        </p>
                    </div>

                    <a
                        href="{{ route('alumni.events.index', ['status' => 'approved']) }}"
                        class="text-sm font-semibold text-[#6B0F1A] hover:underline"
                    >
                        View all
                    </a>
                </div>

                <div class="mt-4 space-y-3">
                    @forelse ($recent['events'] as $event)
                        <div class="rounded-lg border border-gray-100 p-3">
                            <p class="truncate text-sm font-semibold text-gray-900">
                                {{ $event->event_title }}
                            </p>

                            <p class="text-xs text-gray-500">
                                {{ \App\Support\DateTimeFormatter::dateOnly($event->event_date) }}
                                @if ($event->event_time)
                                    · {{ \App\Support\DateTimeFormatter::time12Hour($event->event_time) }}
                                @endif
                            </p>
                        </div>
                    @empty
                        <div class="rounded-lg border border-dashed border-gray-200 bg-gray-50 p-6 text-center">
                            <p class="text-sm text-gray-500">
                                No upcoming events yet.
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- My Recent Donations -->
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">
                            My Recent Donations
                        </h2>

                        <p class="mt-1 text-sm text-gray-500">
                            Your latest donation records and verification status.
                        </p>
                    </div>

                    <a
                        href="{{ route('alumni.donations.index') }}"
                        class="text-sm font-semibold text-[#6B0F1A] hover:underline"
                    >
                        View all
                    </a>
                </div>

                <div class="mt-4 space-y-3">
                    @forelse ($recent['donations'] as $donation)
                        <div class="flex flex-col gap-3 rounded-lg border border-gray-100 p-3 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm font-semibold text-gray-900">
                                    ₱{{ number_format($donation->amount, 2) }}
                                </p>

                                <p class="text-xs text-gray-500">
                                    {{ \App\Support\DateTimeFormatter::dateOnly($donation->donation_date) }}
                                </p>
                            </div>

                            <span class="w-fit rounded-full border px-3 py-1 text-xs font-semibold {{ $statusColors[$donation->status] ?? 'bg-gray-100 text-gray-700 border-gray-200' }}">
                                {{ ucfirst($donation->status) }}
                            </span>
                        </div>
                    @empty
                        <div class="rounded-lg border border-dashed border-gray-200 bg-gray-50 p-6 text-center">
                            <p class="text-sm text-gray-500">
                                No donation records yet.
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Latest Announcements -->
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">
                            Latest Announcements
                        </h2>

                        <p class="mt-1 text-sm text-gray-500">
                            Recently published official announcements.
                        </p>
                    </div>

                    <a
                        href="{{ route('alumni.announcements.index') }}"
                        class="text-sm font-semibold text-[#6B0F1A] hover:underline"
                    >
                        View all
                    </a>
                </div>

                <div class="mt-4 space-y-3">
                    @forelse ($recent['announcements'] as $announcement)
                        <div class="rounded-lg border border-gray-100 p-3">
                            <p class="truncate text-sm font-semibold text-gray-900">
                                {{ $announcement->title }}
                            </p>

                            <p class="text-xs text-gray-500">
                                {{ \App\Support\DateTimeFormatter::dateWithTime($announcement->published_at ?? $announcement->created_at) }}
                            </p>
                        </div>
                    @empty
                        <div class="rounded-lg border border-dashed border-gray-200 bg-gray-50 p-6 text-center">
                            <p class="text-sm text-gray-500">
                                No announcements yet.
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Recent Notifications -->
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm xl:col-span-2">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">
                            Recent Notifications
                        </h2>

                        <p class="mt-1 text-sm text-gray-500">
                            Latest system updates related to your submissions and announcements.
                        </p>
                    </div>

                    <a
                        href="{{ route('alumni.notifications.index') }}"
                        class="text-sm font-semibold text-[#6B0F1A] hover:underline"
                    >
                        View all
                    </a>
                </div>

                <div class="mt-4 space-y-3">
                    @forelse ($recent['notifications'] as $notification)
                        <div class="rounded-lg border border-gray-100 p-3">
                            <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">
                                <p class="text-sm leading-relaxed text-gray-800">
                                    {{ $notification->message }}
                                </p>

                                <span class="w-fit shrink-0 rounded-full border px-3 py-1 text-xs font-semibold {{ $notification->status === 'unread' ? 'bg-amber-50 text-amber-700 border-amber-200' : 'bg-gray-100 text-gray-600 border-gray-200' }}">
                                    {{ ucfirst($notification->status) }}
                                </span>
                            </div>

                            <p class="mt-2 text-xs text-gray-500">
                                {{ \App\Support\DateTimeFormatter::dateWithTime($notification->created_at) }}
                            </p>
                        </div>
                    @empty
                        <div class="rounded-lg border border-dashed border-gray-200 bg-gray-50 p-6 text-center">
                            <p class="text-sm text-gray-500">
                                No notifications yet.
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>