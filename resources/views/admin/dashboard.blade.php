<x-app-layout>
    @php
        $statusColors = [
            'pending' => 'bg-amber-50 text-amber-700 border-amber-200',
            'approved' => 'bg-green-50 text-green-700 border-green-200',
            'verified' => 'bg-green-50 text-green-700 border-green-200',
            'published' => 'bg-green-50 text-green-700 border-green-200',
            'rejected' => 'bg-red-50 text-red-700 border-red-200',
            'archived' => 'bg-gray-100 text-gray-700 border-gray-200',
            'draft' => 'bg-gray-50 text-gray-700 border-gray-200',
            'completed' => 'bg-green-50 text-green-700 border-green-200',
            'cancelled' => 'bg-red-50 text-red-700 border-red-200',
        ];
    @endphp

    <div class="space-y-6">
        <!-- Page Header -->
        <div>
            <h1 class="text-2xl font-bold text-gray-900">
                Admin Dashboard
            </h1>

            <p class="mt-1 text-sm text-gray-600">
                Overview of alumni records, opportunities, events, donations, announcements, and notifications.
            </p>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4">
            <x-summary-card
                title="Total Alumni"
                value="{{ $summary['totalAlumni'] }}"
                variant="primary"
                :href="route('admin.alumni-profiles.index')"
            />

            <x-summary-card
                title="Total Job Posts"
                value="{{ $summary['totalJobPosts'] }}"
                variant="primary"
                :href="route('admin.job-posts.index')"
            />

            <x-summary-card
                title="Pending Job Posts"
                value="{{ $summary['pendingJobPosts'] }}"
                variant="warning"
                :href="route('admin.job-posts.index', ['status' => 'pending'])"
            />

            <x-summary-card
                title="Approved Job Posts"
                value="{{ $summary['approvedJobPosts'] }}"
                variant="success"
                :href="route('admin.job-posts.index', ['status' => 'approved'])"
            />

            <x-summary-card
                title="Total Events"
                value="{{ $summary['totalEvents'] }}"
                variant="primary"
                :href="route('admin.events.index')"
            />

            <x-summary-card
                title="Pending Events"
                value="{{ $summary['pendingEvents'] }}"
                variant="warning"
                :href="route('admin.events.index', ['status' => 'pending'])"
            />

            <x-summary-card
                title="Approved Events"
                value="{{ $summary['approvedEvents'] }}"
                variant="success"
                :href="route('admin.events.index', ['status' => 'approved'])"
            />

            <x-summary-card
                title="Total Verified Donations"
                value="₱{{ number_format($summary['totalVerifiedDonations'], 2) }}"
                variant="success"
                :href="route('admin.donations.index', ['status' => 'verified'])"
            />

            <x-summary-card
                title="Pending Donations"
                value="{{ $summary['pendingDonations'] }}"
                variant="warning"
                :href="route('admin.donations.index', ['status' => 'pending'])"
            />

            <x-summary-card
                title="Total Announcements"
                value="{{ $summary['totalAnnouncements'] }}"
                variant="primary"
                :href="route('admin.announcements.index')"
            />

            <x-summary-card
                title="Published Announcements"
                value="{{ $summary['publishedAnnouncements'] }}"
                variant="success"
                :href="route('admin.announcements.index', ['status' => 'published'])"
            />

            <x-summary-card
                title="Unread Notifications"
                value="{{ $summary['unreadNotifications'] }}"
                variant="warning"
                :href="route('admin.notifications.index', ['status' => 'unread'])"
            />
        </div>

        <!-- Recent Activity Sections -->
        <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
            <!-- Recent Registered Alumni -->
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">
                            Recent Registered Alumni
                        </h2>

                        <p class="mt-1 text-sm text-gray-500">
                            Latest alumni accounts added to the system.
                        </p>
                    </div>

                    <a
                        href="{{ route('admin.alumni-profiles.index') }}"
                        class="text-sm font-semibold text-[#6B0F1A] hover:underline"
                    >
                        View all
                    </a>
                </div>

                <div class="mt-4 space-y-3">
                    @forelse ($recent['alumni'] as $alumni)
                        <div class="flex flex-col gap-3 rounded-lg border border-gray-100 p-3 sm:flex-row sm:items-center sm:justify-between">
                            <div class="min-w-0">
                                <p class="truncate text-sm font-semibold text-gray-900">
                                    {{ $alumni->full_name }}
                                </p>

                                <p class="truncate text-xs text-gray-500">
                                    {{ $alumni->email }}
                                </p>
                            </div>

                            <span class="shrink-0 text-xs text-gray-500">
                                {{ \App\Support\DateTimeFormatter::dateWithTime($alumni->created_at) }}
                            </span>
                        </div>
                    @empty
                        <div class="rounded-lg border border-dashed border-gray-200 bg-gray-50 p-6 text-center">
                            <p class="text-sm text-gray-500">
                                No alumni records yet.
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Recent Job Posts -->
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">
                            Recent Job Posts
                        </h2>

                        <p class="mt-1 text-sm text-gray-500">
                            Latest opportunities submitted or created.
                        </p>
                    </div>

                    <a
                        href="{{ route('admin.job-posts.index') }}"
                        class="text-sm font-semibold text-[#6B0F1A] hover:underline"
                    >
                        View all
                    </a>
                </div>

                <div class="mt-4 space-y-3">
                    @forelse ($recent['jobPosts'] as $jobPost)
                        <div class="flex flex-col gap-3 rounded-lg border border-gray-100 p-3 sm:flex-row sm:items-center sm:justify-between">
                            <div class="min-w-0">
                                <p class="truncate text-sm font-semibold text-gray-900">
                                    {{ $jobPost->job_title }}
                                </p>

                                <p class="truncate text-xs text-gray-500">
                                    {{ $jobPost->company_name }}
                                </p>
                            </div>

                            <span class="w-fit shrink-0 rounded-full border px-3 py-1 text-xs font-semibold {{ $statusColors[$jobPost->status] ?? 'bg-gray-100 text-gray-700 border-gray-200' }}">
                                {{ ucfirst($jobPost->status) }}
                            </span>
                        </div>
                    @empty
                        <div class="rounded-lg border border-dashed border-gray-200 bg-gray-50 p-6 text-center">
                            <p class="text-sm text-gray-500">
                                No job posts yet.
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Recent Event Submissions -->
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">
                            Recent Event Submissions
                        </h2>

                        <p class="mt-1 text-sm text-gray-500">
                            Latest alumni events and event proposals.
                        </p>
                    </div>

                    <a
                        href="{{ route('admin.events.index') }}"
                        class="text-sm font-semibold text-[#6B0F1A] hover:underline"
                    >
                        View all
                    </a>
                </div>

                <div class="mt-4 space-y-3">
                    @forelse ($recent['events'] as $event)
                        <div class="flex flex-col gap-3 rounded-lg border border-gray-100 p-3 sm:flex-row sm:items-center sm:justify-between">
                            <div class="min-w-0">
                                <p class="truncate text-sm font-semibold text-gray-900">
                                    {{ $event->event_title }}
                                </p>

                                <p class="truncate text-xs text-gray-500">
                                    {{ \App\Support\DateTimeFormatter::dateOnly($event->event_date) }}
                                    @if ($event->event_time)
                                        · {{ \App\Support\DateTimeFormatter::time12Hour($event->event_time) }}
                                    @endif
                                </p>
                            </div>

                            <span class="w-fit shrink-0 rounded-full border px-3 py-1 text-xs font-semibold {{ $statusColors[$event->status] ?? 'bg-gray-100 text-gray-700 border-gray-200' }}">
                                {{ ucfirst($event->status) }}
                            </span>
                        </div>
                    @empty
                        <div class="rounded-lg border border-dashed border-gray-200 bg-gray-50 p-6 text-center">
                            <p class="text-sm text-gray-500">
                                No events yet.
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Recent Donations -->
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">
                            Recent Donations
                        </h2>

                        <p class="mt-1 text-sm text-gray-500">
                            Latest submitted and verified donation records.
                        </p>
                    </div>

                    <a
                        href="{{ route('admin.donations.index') }}"
                        class="text-sm font-semibold text-[#6B0F1A] hover:underline"
                    >
                        View all
                    </a>
                </div>

                <div class="mt-4 space-y-3">
                    @forelse ($recent['donations'] as $donation)
                        <div class="flex flex-col gap-3 rounded-lg border border-gray-100 p-3 sm:flex-row sm:items-center sm:justify-between">
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-gray-900">
                                    {{ $donation->donor_name }}
                                </p>

                                <p class="text-xs text-gray-500">
                                    ₱{{ number_format($donation->amount, 2) }}
                                    · {{ \App\Support\DateTimeFormatter::dateOnly($donation->donation_date) }}
                                </p>
                            </div>

                            <span class="w-fit shrink-0 rounded-full border px-3 py-1 text-xs font-semibold {{ $statusColors[$donation->status] ?? 'bg-gray-100 text-gray-700 border-gray-200' }}">
                                {{ ucfirst($donation->status) }}
                            </span>
                        </div>
                    @empty
                        <div class="rounded-lg border border-dashed border-gray-200 bg-gray-50 p-6 text-center">
                            <p class="text-sm text-gray-500">
                                No donations yet.
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Recent Announcements -->
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">
                            Recent Announcements
                        </h2>

                        <p class="mt-1 text-sm text-gray-500">
                            Latest official announcements created by admin.
                        </p>
                    </div>

                    <a
                        href="{{ route('admin.announcements.index') }}"
                        class="text-sm font-semibold text-[#6B0F1A] hover:underline"
                    >
                        View all
                    </a>
                </div>

                <div class="mt-4 space-y-3">
                    @forelse ($recent['announcements'] as $announcement)
                        <div class="flex flex-col gap-3 rounded-lg border border-gray-100 p-3 sm:flex-row sm:items-center sm:justify-between">
                            <div class="min-w-0">
                                <p class="truncate text-sm font-semibold text-gray-900">
                                    {{ $announcement->title }}
                                </p>

                                <p class="truncate text-xs text-gray-500">
                                    {{ \App\Support\DateTimeFormatter::dateWithTime($announcement->created_at) }}
                                </p>
                            </div>

                            <span class="w-fit shrink-0 rounded-full border px-3 py-1 text-xs font-semibold {{ $statusColors[$announcement->status] ?? 'bg-gray-100 text-gray-700 border-gray-200' }}">
                                {{ ucfirst($announcement->status) }}
                            </span>
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
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">
                            Recent Notifications
                        </h2>

                        <p class="mt-1 text-sm text-gray-500">
                            Latest system updates and review alerts.
                        </p>
                    </div>

                    <a
                        href="{{ route('admin.notifications.index') }}"
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