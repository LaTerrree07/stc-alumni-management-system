<x-app-layout>
    <div class="mx-auto max-w-5xl space-y-6">
        <!-- Header -->
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    Alumni Profile Details
                </h1>

                <p class="mt-1 text-sm text-gray-600">
                    View complete alumni account and profile information.
                </p>
            </div>

            <a
                href="{{ route('admin.alumni-profiles.index') }}"
                class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50"
            >
                Back
            </a>
        </div>

        <!-- Profile Card -->
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-6 md:flex-row md:items-start">
                <div class="h-32 w-32 shrink-0 overflow-hidden rounded-full border border-gray-200 bg-gray-100">
                    @if ($user->alumniProfile && $user->alumniProfile->profile_picture)
                        <img
                            src="{{ asset('storage/' . $user->alumniProfile->profile_picture) }}"
                            alt="{{ $user->full_name }}"
                            class="h-full w-full object-cover"
                        >
                    @else
                        <div class="flex h-full w-full items-center justify-center text-4xl font-bold text-gray-400">
                            {{ strtoupper(substr($user->first_name, 0, 1)) }}
                        </div>
                    @endif
                </div>

                <div class="flex-1">
                    <h2 class="text-2xl font-bold text-gray-900">
                        {{ $user->full_name }}
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        {{ $user->email }}
                    </p>

                    <div class="mt-4 flex flex-wrap gap-2">
                        <span class="rounded-full bg-green-50 px-3 py-1 text-xs font-semibold text-green-700 border border-green-200">
                            {{ ucfirst($user->status) }}
                        </span>

                        <span class="rounded-full bg-[#6B0F1A]/10 px-3 py-1 text-xs font-semibold text-[#6B0F1A] border border-[#6B0F1A]/20">
                            {{ ucfirst($user->role) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Details -->
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-bold text-gray-900">
                    Academic Information
                </h3>

                <dl class="mt-4 space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Program</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ $user->alumniProfile->program ?? 'Not provided' }}
                        </dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">Graduation Year</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ $user->alumniProfile->graduation_year ?? 'Not provided' }}
                        </dd>
                    </div>
                </dl>
            </div>

            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-bold text-gray-900">
                    Career Information
                </h3>

                <dl class="mt-4 space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Job Title</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ $user->alumniProfile->job_title ?? 'Not provided' }}
                        </dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">Company</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ $user->alumniProfile->company ?? 'Not provided' }}
                        </dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">Skills</dt>
                        <dd class="mt-1 text-sm text-gray-900 whitespace-pre-line">
                            {{ $user->alumniProfile->skills ?? 'Not provided' }}
                        </dd>
                    </div>
                </dl>
            </div>

            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm md:col-span-2">
                <h3 class="text-lg font-bold text-gray-900">
                    Contact Information
                </h3>

                <dl class="mt-4 grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Contact Number</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ $user->alumniProfile->contact_number ?? 'Not provided' }}
                        </dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">Location</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ $user->alumniProfile->location ?? 'Not provided' }}
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</x-app-layout>