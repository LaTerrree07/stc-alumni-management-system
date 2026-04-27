<x-app-layout>
    @php
        $routePrefix = auth()->user()->role === 'admin' ? 'admin' : 'alumni';

      $statusClasses = [
    'draft' => 'bg-gray-50 text-gray-700 border-gray-200',
    'published' => 'bg-green-50 text-green-700 border-green-200',
    'archived' => 'bg-gray-100 text-gray-600 border-gray-200',
];
    @endphp

    <div class="mx-auto max-w-5xl space-y-6">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    Announcement Details
                </h1>

                <p class="mt-1 text-sm text-gray-600">
                    View announcement information and publication details.
                </p>
            </div>

            <a
                href="{{ route($routePrefix . '.announcements.index') }}"
                class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50"
            >
                Back
            </a>
        </div>

        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            @if ($announcement->image)
                <img
                    src="{{ asset('storage/' . $announcement->image) }}"
                    alt="{{ $announcement->title }}"
                    class="h-80 w-full object-cover"
                >
            @endif

            <div class="p-6">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">
                            {{ $announcement->title }}
                        </h2>

                        <p class="mt-2 text-sm text-gray-500">
                            Posted by {{ $announcement->creator->full_name ?? 'Admin' }}
                        </p>
                    </div>

                    @if (auth()->user()->role === 'admin')
                        <span class="w-fit rounded-full border px-3 py-1 text-xs font-semibold {{ $statusClasses[$announcement->status] ?? 'bg-gray-100 text-gray-700 border-gray-200' }}">
                            {{ ucfirst($announcement->status) }}
                        </span>
                    @endif
                </div>

                <div class="mt-6 grid grid-cols-1 gap-4 rounded-xl border border-gray-100 bg-gray-50 p-4 md:grid-cols-2">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Created Date</p>
                        <p class="mt-1 text-sm text-gray-900">
                            {{ \App\Support\DateTimeFormatter::dateWithTime($announcement->created_at) }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-gray-500">Published Date</p>
                        <p class="mt-1 text-sm text-gray-900">
                            {{ \App\Support\DateTimeFormatter::dateWithTime($announcement->published_at) }}
                        </p>
                    </div>
                </div>

                <div class="mt-6">
                    <h3 class="text-lg font-bold text-gray-900">
                        Content
                    </h3>

                    <p class="mt-3 whitespace-pre-line text-sm leading-relaxed text-gray-700">
                        {{ $announcement->content }}
                    </p>
                </div>
            </div>
        </div>

        @if (auth()->user()->role === 'admin')
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-bold text-gray-900">
                    Announcement Actions
                </h2>

                <div class="mt-4 flex flex-wrap gap-3">
                    <a
                        href="{{ route('admin.announcements.edit', $announcement) }}"
                        class="rounded-lg border border-amber-300 bg-amber-50 px-4 py-2 text-sm font-semibold text-amber-700 hover:bg-amber-100"
                    >
                        Edit
                    </a>

                    @if ($announcement->status !== 'published')
                        <form method="POST" action="{{ route('admin.announcements.publish', $announcement) }}">
                            @csrf
                            @method('PATCH')

                            <button
                                type="submit"
                                class="rounded-lg bg-[#6B0F1A] px-4 py-2 text-sm font-semibold text-white hover:bg-[#4A0A12]"
                                data-confirm
                                data-confirm-title="Publish Announcement"
                                data-confirm-message="Are you sure you want to publish this announcement? Alumni users will be able to view it."
                                data-confirm-text="Publish"
                                data-confirm-variant="primary"
                                data-confirm-icon="neutral"
                            >
                                Publish
                            </button>
                        </form>
                    @endif

                    @if ($announcement->status !== 'archived')
                        <form method="POST" action="{{ route('admin.announcements.archive', $announcement) }}">
                            @csrf
                            @method('PATCH')

                            <button
                                type="submit"
                                class="rounded-lg bg-gray-700 px-4 py-2 text-sm font-semibold text-white hover:bg-gray-800"
                                data-confirm
                                data-confirm-title="Archive Announcement"
                                data-confirm-message="Are you sure you want to archive this announcement?"
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