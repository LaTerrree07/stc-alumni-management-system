<x-app-layout>
    <div class="space-y-6">
        <!-- Page Header -->
        <div>
            <h1 class="text-2xl font-bold text-gray-900">
                Alumni Profiles
            </h1>

            <p class="mt-1 text-sm text-gray-600">
                View registered alumni accounts and their profile information.
            </p>
        </div>

        <!-- Search Card -->
        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <form method="GET" action="{{ route('admin.alumni-profiles.index') }}" class="flex flex-col gap-3 sm:flex-row">
                <div class="flex-1">
                    <label for="search" class="sr-only">Search alumni profiles</label>

                    <input
                        id="search"
                        type="text"
                        name="search"
                        value="{{ $search }}"
                        placeholder="Search by name, email, program, year, company, location, skills..."
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#6B0F1A] focus:ring-[#6B0F1A]"
                    >
                </div>

                <button
                    type="submit"
                    class="inline-flex items-center justify-center rounded-lg bg-[#6B0F1A] px-4 py-2 text-sm font-semibold text-white hover:bg-[#4A0A12] focus:outline-none focus:ring-2 focus:ring-[#6B0F1A] focus:ring-offset-2"
                >
                    Search
                </button>

                @if ($search)
                    <a
                        href="{{ route('admin.alumni-profiles.index') }}"
                        class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50"
                    >
                        Clear
                    </a>
                @endif
            </form>
        </div>

        <!-- Table Card -->
        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Alumni
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Program
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Graduation Year
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Career
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Location
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Action
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse ($alumni as $user)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="h-11 w-11 overflow-hidden rounded-full bg-gray-100 border border-gray-200">
                                            @if ($user->alumniProfile && $user->alumniProfile->profile_picture)
                                                <img
                                                    src="{{ asset('storage/' . $user->alumniProfile->profile_picture) }}"
                                                    alt="{{ $user->full_name }}"
                                                    class="h-full w-full object-cover"
                                                >
                                            @else
                                                <div class="flex h-full w-full items-center justify-center text-sm font-bold text-gray-500">
                                                    {{ strtoupper(substr($user->first_name, 0, 1)) }}
                                                </div>
                                            @endif
                                        </div>

                                        <div>
                                            <p class="font-semibold text-gray-900">
                                                {{ $user->full_name }}
                                            </p>

                                            <p class="text-sm text-gray-500">
                                                {{ $user->email }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-sm text-gray-700">
                                    {{ $user->alumniProfile->program ?? 'Not provided' }}
                                </td>

                                <td class="px-6 py-4 text-sm text-gray-700">
                                    {{ $user->alumniProfile->graduation_year ?? 'Not provided' }}
                                </td>

                                <td class="px-6 py-4 text-sm text-gray-700">
                                    <p>{{ $user->alumniProfile->job_title ?? 'Not provided' }}</p>
                                    <p class="text-xs text-gray-500">
                                        {{ $user->alumniProfile->company ?? '' }}
                                    </p>
                                </td>

                                <td class="px-6 py-4 text-sm text-gray-700">
                                    {{ $user->alumniProfile->location ?? 'Not provided' }}
                                </td>

                                <td class="px-6 py-4 text-right">
                                    <x-action-icon
    :href="route('admin.alumni-profiles.show', $user)"
    icon="eye"
    label="View alumni profile"
    variant="view"
/>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <p class="text-sm font-medium text-gray-900">
                                        No alumni profiles found.
                                    </p>

                                    <p class="mt-1 text-sm text-gray-500">
                                        Alumni records will appear here once alumni accounts are registered.
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($alumni->hasPages())
                <div class="border-t border-gray-100 px-6 py-4">
                    {{ $alumni->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>