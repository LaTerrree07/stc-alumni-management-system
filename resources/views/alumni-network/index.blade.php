<x-app-layout>
    @php
        $routePrefix = auth()->user()->role === 'admin' ? 'admin' : 'alumni';
    @endphp

    <div class="space-y-6">
        <!-- Page Header -->
        <div>
            <h1 class="text-2xl font-bold text-gray-900">
                Alumni Network
            </h1>

            <p class="mt-1 text-sm text-gray-600">
                Browse registered alumni and connect with their academic and career information.
            </p>
        </div>

        <!-- Search and Filters -->
        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <form method="GET" action="{{ route($routePrefix . '.alumni-network.index') }}" class="space-y-4">
                <div>
                    <label for="search" class="sr-only">Search alumni</label>

                    <input
                        id="search"
                        type="text"
                        name="search"
                        value="{{ $search }}"
                        placeholder="Search by name, program, company, location, skills, or job title..."
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#6B0F1A] focus:ring-[#6B0F1A]"
                    >
                </div>

                <div class="grid grid-cols-1 gap-3 md:grid-cols-4">
                    <select
                        name="graduation_year"
                        class="rounded-lg border-gray-300 shadow-sm focus:border-[#6B0F1A] focus:ring-[#6B0F1A]"
                    >
                        <option value="">All Years</option>
                        @foreach ($graduationYears as $year)
                            <option value="{{ $year }}" @selected($graduationYear == $year)>
                                {{ $year }}
                            </option>
                        @endforeach
                    </select>

                    <select
                        name="program"
                        class="rounded-lg border-gray-300 shadow-sm focus:border-[#6B0F1A] focus:ring-[#6B0F1A]"
                    >
                        <option value="">All Programs</option>
                        @foreach ($programs as $programOption)
                            <option value="{{ $programOption }}" @selected($program == $programOption)>
                                {{ $programOption }}
                            </option>
                        @endforeach
                    </select>

                    <select
                        name="location"
                        class="rounded-lg border-gray-300 shadow-sm focus:border-[#6B0F1A] focus:ring-[#6B0F1A]"
                    >
                        <option value="">All Locations</option>
                        @foreach ($locations as $locationOption)
                            <option value="{{ $locationOption }}" @selected($location == $locationOption)>
                                {{ $locationOption }}
                            </option>
                        @endforeach
                    </select>

                    <div class="flex gap-2">
                        <button
                            type="submit"
                            class="flex-1 rounded-lg bg-[#6B0F1A] px-4 py-2 text-sm font-semibold text-white hover:bg-[#4A0A12] focus:outline-none focus:ring-2 focus:ring-[#6B0F1A] focus:ring-offset-2"
                        >
                            Filter
                        </button>

                        @if ($search || $graduationYear || $program || $location)
                            <a
                                href="{{ route($routePrefix . '.alumni-network.index') }}"
                                class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50"
                            >
                                Clear
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        <!-- Alumni Cards -->
        @if ($alumni->count())
            <div class="grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-3">
                @foreach ($alumni as $user)
                    <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm transition hover:shadow-md">
                        <div class="flex items-start gap-4">
                            <div class="h-16 w-16 shrink-0 overflow-hidden rounded-full border border-gray-200 bg-gray-100">
                                @if ($user->alumniProfile && $user->alumniProfile->profile_picture)
                                    <img
                                        src="{{ asset('storage/' . $user->alumniProfile->profile_picture) }}"
                                        alt="{{ $user->full_name }}"
                                        class="h-full w-full object-cover"
                                    >
                                @else
                                    <div class="flex h-full w-full items-center justify-center text-xl font-bold text-gray-500">
                                        {{ strtoupper(substr($user->first_name, 0, 1)) }}
                                    </div>
                                @endif
                            </div>

                            <div class="min-w-0 flex-1">
                                <h2 class="truncate text-base font-bold text-gray-900">
                                    {{ $user->full_name }}
                                </h2>

                                <p class="mt-1 text-sm text-gray-500">
                                    {{ $user->alumniProfile->job_title ?? 'Job title not provided' }}
                                </p>

                                <p class="text-sm text-gray-500">
                                    {{ $user->alumniProfile->company ?? 'Company not provided' }}
                                </p>
                            </div>
                        </div>

                        <div class="mt-4 space-y-2 text-sm text-gray-700">
                            <p>
                                <span class="font-medium text-gray-900">Program:</span>
                                {{ $user->alumniProfile->program ?? 'Not provided' }}
                            </p>

                            <p>
                                <span class="font-medium text-gray-900">Year:</span>
                                {{ $user->alumniProfile->graduation_year ?? 'Not provided' }}
                            </p>

                            <p>
                                <span class="font-medium text-gray-900">Location:</span>
                                {{ $user->alumniProfile->location ?? 'Not provided' }}
                            </p>

                            <p class="line-clamp-2">
                                <span class="font-medium text-gray-900">Skills:</span>
                                {{ $user->alumniProfile->skills ?? 'Not provided' }}
                            </p>
                        </div>

                        <div class="mt-5 flex items-center justify-between border-t border-gray-100 pt-4">
                            <span class="rounded-full bg-green-50 px-3 py-1 text-xs font-semibold text-green-700 border border-green-200">
                                Active Alumni
                            </span>

                            <a
                                href="{{ route($routePrefix . '.alumni-network.show', $user) }}"
                                class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50"
                            >
                                View Profile
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div>
                {{ $alumni->links() }}
            </div>
        @else
            <div class="rounded-xl border border-gray-200 bg-white p-10 text-center shadow-sm">
                <h2 class="text-base font-semibold text-gray-900">
                    No alumni found.
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Try changing your search or filter options.
                </p>
            </div>
        @endif
    </div>
</x-app-layout>