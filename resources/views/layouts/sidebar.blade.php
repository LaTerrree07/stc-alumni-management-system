<aside
    class="fixed inset-y-0 left-0 z-50 w-64 transform bg-[#6B0F1A] text-white transition-transform duration-300 ease-in-out lg:translate-x-0"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
>
    <div class="flex h-full flex-col">
        <!-- Logo Area -->
        <div class="flex items-center gap-3 border-b border-white/10 px-5 py-5">
            <div class="flex h-11 w-11 shrink-0 items-center justify-center overflow-hidden rounded-full bg-white p-1.5">
                <img
                    src="{{ asset('images/stcti-logo.png') }}"
                    alt="STCTI Logo"
                    class="h-full w-full object-contain"
                >
            </div>

            <div class="min-w-0">
                <h1 class="truncate text-sm font-bold leading-tight">
                    STCTI
                </h1>

                <p class="text-xs leading-tight text-white/70">
                    Alumni Management System
                </p>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 space-y-1 overflow-y-auto px-3 py-4">
            @if (auth()->user()->role === 'admin')
                <x-sidebar-link
                    :href="route('admin.dashboard')"
                    :active="request()->routeIs('admin.dashboard')"
                    label="Dashboard"
                    icon="dashboard"
                />

                <x-sidebar-link
                    :href="route('admin.alumni-profiles.index')"
                    :active="request()->routeIs('admin.alumni-profiles.*')"
                    label="Alumni Profiles"
                    icon="users"
                />

                <x-sidebar-link
                    :href="route('admin.alumni-network.index')"
                    :active="request()->routeIs('admin.alumni-network.*')"
                    label="Alumni Network"
                    icon="network"
                />

                <x-sidebar-link
                    :href="route('admin.job-posts.index')"
                    :active="request()->routeIs('admin.job-posts.*')"
                    label="Opportunities"
                    icon="briefcase"
                />

                <x-sidebar-link
                    :href="route('admin.events.index')"
                    :active="request()->routeIs('admin.events.*')"
                    label="Events"
                    icon="calendar"
                />

                <x-sidebar-link
                    :href="route('admin.event-funds.index')"
                    :active="request()->routeIs('admin.event-funds.*')"
                    label="Event Funds"
                    icon="fund"
                />

                <x-sidebar-link
                    :href="route('admin.donations.index')"
                    :active="request()->routeIs('admin.donations.*')"
                    label="Donations"
                    icon="donation"
                />

                <x-sidebar-link
                    :href="route('admin.announcements.index')"
                    :active="request()->routeIs('admin.announcements.*')"
                    label="Announcements"
                    icon="megaphone"
                />

                <x-sidebar-link
                    :href="route('admin.notifications.index')"
                    :active="request()->routeIs('admin.notifications.*')"
                    label="Notifications"
                    icon="bell"
                />
            @endif

            @if (auth()->user()->role === 'alumni')
                <x-sidebar-link
                    :href="route('alumni.dashboard')"
                    :active="request()->routeIs('alumni.dashboard')"
                    label="Dashboard"
                    icon="dashboard"
                />

                <x-sidebar-link
                    :href="route('alumni.profile.edit')"
                    :active="request()->routeIs('alumni.profile.*')"
                    label="My Profile"
                    icon="user"
                />

                <x-sidebar-link
                    :href="route('alumni.alumni-network.index')"
                    :active="request()->routeIs('alumni.alumni-network.*')"
                    label="Alumni Network"
                    icon="network"
                />

                <x-sidebar-link
                    :href="route('alumni.job-posts.index')"
                    :active="request()->routeIs('alumni.job-posts.*')"
                    label="Opportunities"
                    icon="briefcase"
                />

                <x-sidebar-link
                    :href="route('alumni.events.index')"
                    :active="request()->routeIs('alumni.events.*')"
                    label="Events"
                    icon="calendar"
                />

                <x-sidebar-link
                    :href="route('alumni.event-funds.index')"
                    :active="request()->routeIs('alumni.event-funds.*')"
                    label="Event Funds"
                    icon="fund"
                />

                <x-sidebar-link
                    :href="route('alumni.donations.index')"
                    :active="request()->routeIs('alumni.donations.*')"
                    label="Donations"
                    icon="donation"
                />

                <x-sidebar-link
                    :href="route('alumni.announcements.index')"
                    :active="request()->routeIs('alumni.announcements.*')"
                    label="Announcements"
                    icon="megaphone"
                />

                <x-sidebar-link
                    :href="route('alumni.notifications.index')"
                    :active="request()->routeIs('alumni.notifications.*')"
                    label="Notifications"
                    icon="bell"
                />
            @endif
        </nav>

        <!-- User Area -->
        <div class="border-t border-white/10 p-3">
            <div class="mb-3 rounded-lg bg-white/10 px-3 py-3">
                <p class="truncate text-sm font-semibold">
                    {{ auth()->user()->full_name }}
                </p>

                <p class="text-xs capitalize text-white/70">
                    {{ auth()->user()->role }}
                </p>
            </div>

            <div class="space-y-1">
                <x-sidebar-link
                    :href="route('profile.edit')"
                    :active="request()->routeIs('profile.edit')"
                    label="Account Settings"
                    icon="settings"
                />

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button
                        type="submit"
                        class="flex w-full items-center gap-3 rounded-lg px-3 py-2 text-sm font-semibold text-white transition hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-white/30"
                        data-confirm
                        data-confirm-title="Log Out"
                        data-confirm-message="Are you sure you want to log out of your account?"
                        data-confirm-text="Log Out"
                        data-confirm-variant="danger"
                        data-confirm-icon="warning"
                    >
                        <svg class="h-5 w-5 shrink-0 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 15l3-3m0 0l-3-3m3 3H9" />
                        </svg>

                        <span>Log Out</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</aside>