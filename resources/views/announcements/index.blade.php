<x-app-layout>
    @php
        $routePrefix = auth()->user()->role === 'admin' ? 'admin' : 'alumni';

        $statusClasses = [
    'draft' => 'bg-gray-50 text-gray-700 border-gray-200',
    'published' => 'bg-green-50 text-green-700 border-green-200',
    'archived' => 'bg-gray-100 text-gray-600 border-gray-200',
];
    @endphp

    <div class="space-y-6">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    Announcements
                </h1>

                <p class="mt-1 text-sm text-gray-600">
                    View official STCTI alumni announcements and updates.
                </p>
            </div>

            @if (auth()->user()->role === 'admin')
                <a
                    href="{{ route('admin.announcements.create') }}"
                    class="inline-flex items-center justify-center rounded-lg bg-[#6B0F1A] px-4 py-2 text-sm font-semibold text-white hover:bg-[#4A0A12]"
                >
                    Add Announcement
                </a>
            @endif
        </div>

        @if (auth()->user()->role === 'admin')
            <div class="grid grid-cols-1 gap-5 md:grid-cols-3">
                <x-summary-card
                    title="Published Announcements"
                    value="{{ $publishedCount }}"
                    variant="success"
                />

                <x-summary-card
                    title="Draft Announcements"
                    value="{{ $draftCount }}"
                    variant="warning"
                />

                <x-summary-card
                    title="Archived Announcements"
                    value="{{ $archivedCount }}"
                    variant="neutral"
                />
            </div>
        @endif

        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <form method="GET" action="{{ route($routePrefix . '.announcements.index') }}" class="space-y-4">
                <input
                    type="text"
                    name="search"
                    value="{{ $search }}"
                    placeholder="Search by title or content..."
                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#6B0F1A] focus:ring-[#6B0F1A]"
                >

                <div class="flex flex-col gap-3 sm:flex-row">
                    @if (auth()->user()->role === 'admin')
                        <select
                            name="status"
                            class="rounded-lg border-gray-300 shadow-sm focus:border-[#6B0F1A] focus:ring-[#6B0F1A]"
                        >
                            <option value="">All Status</option>
                            <option value="draft" @selected($status === 'draft')>Draft</option>
                            <option value="published" @selected($status === 'published')>Published</option>
                            <option value="archived" @selected($status === 'archived')>Archived</option>
                        </select>
                    @endif

                    <button
                        type="submit"
                        class="rounded-lg bg-[#6B0F1A] px-4 py-2 text-sm font-semibold text-white hover:bg-[#4A0A12]"
                    >
                        Search
                    </button>

                    @if ($search || $status)
                        <a
                            href="{{ route($routePrefix . '.announcements.index') }}"
                            class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-center text-sm font-semibold text-gray-700 hover:bg-gray-50"
                        >
                            Clear
                        </a>
                    @endif
                </div>
            </form>
        </div>

        @if ($announcements->count())
            <div class="grid grid-cols-1 gap-5 lg:grid-cols-2">
                @foreach ($announcements as $announcement)
                    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm transition hover:shadow-md">
                        @if ($announcement->image)
                            <img
                                src="{{ asset('storage/' . $announcement->image) }}"
                                alt="{{ $announcement->title }}"
                                class="h-48 w-full object-cover"
                            >
                        @endif

                        <div class="p-5">
                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <h2 class="line-clamp-2 text-lg font-bold text-gray-900">
                                        {{ $announcement->title }}
                                    </h2>

                                    <p class="mt-1 text-sm text-gray-500">
                                        Posted by {{ $announcement->creator->full_name ?? 'Admin' }}
                                    </p>
                                </div>

                                @if (auth()->user()->role === 'admin')
                                    <span class="shrink-0 rounded-full border px-3 py-1 text-xs font-semibold {{ $statusClasses[$announcement->status] ?? 'bg-gray-100 text-gray-700 border-gray-200' }}">
                                        {{ ucfirst($announcement->status) }}
                                    </span>
                                @endif
                            </div>

                            <p class="mt-4 line-clamp-3 text-sm leading-relaxed text-gray-600">
                                {{ $announcement->content }}
                            </p>

                            <div class="mt-5 flex items-center justify-between border-t border-gray-100 pt-4">
                                <p class="text-xs text-gray-500">
                                    @if ($announcement->published_at)
                                        Published {{ \App\Support\DateTimeFormatter::dateWithTime($announcement->published_at) }}
                                    @else
                                        Created {{ \App\Support\DateTimeFormatter::dateWithTime($announcement->created_at) }}
                                    @endif
                                </p>

                                <div class="flex items-center gap-2">
                                    <x-action-icon
                                        :href="route($routePrefix . '.announcements.show', $announcement)"
                                        icon="eye"
                                        label="View announcement"
                                        variant="view"
                                    />

                                    @if (auth()->user()->role === 'admin')
                                        <x-action-icon
                                            :href="route('admin.announcements.edit', $announcement)"
                                            icon="pencil"
                                            label="Edit announcement"
                                            variant="edit"
                                        />

                                        @if ($announcement->status !== 'published')
                                            <form method="POST" action="{{ route('admin.announcements.publish', $announcement) }}">
                                                @csrf
                                                @method('PATCH')

                                                <x-action-icon
                                                    type="button"
                                                    icon="megaphone"
                                                    label="Publish announcement"
                                                    variant="publish"
                                                    data-confirm
                                                    data-confirm-title="Publish Announcement"
                                                    data-confirm-message="Are you sure you want to publish this announcement? Alumni users will be able to view it."
                                                    data-confirm-text="Publish"
                                                    data-confirm-variant="primary"
                                                    data-confirm-icon="neutral"
                                                />
                                            </form>
                                        @endif

                                        @if ($announcement->status !== 'archived')
                                            <form method="POST" action="{{ route('admin.announcements.archive', $announcement) }}">
                                                @csrf
                                                @method('PATCH')

                                                <x-action-icon
                                                    type="button"
                                                    icon="archive"
                                                    label="Archive announcement"
                                                    variant="archive"
                                                    data-confirm
                                                    data-confirm-title="Archive Announcement"
                                                    data-confirm-message="Are you sure you want to archive this announcement?"
                                                    data-confirm-text="Archive"
                                                    data-confirm-variant="neutral"
                                                    data-confirm-icon="warning"
                                                />
                                            </form>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div>
                {{ $announcements->links() }}
            </div>
        @else
            <div class="rounded-xl border border-gray-200 bg-white p-10 text-center shadow-sm">
                <h2 class="text-base font-semibold text-gray-900">
                    No announcements found.
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Announcements will appear here once available.
                </p>
            </div>
        @endif
    </div>
</x-app-layout>