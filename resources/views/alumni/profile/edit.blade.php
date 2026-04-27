<x-app-layout>
    <div class="mx-auto max-w-4xl">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">My Profile</h1>
            <p class="mt-1 text-sm text-gray-600">
                Update your personal, academic, and career information.
            </p>
        </div>

       <div class="mb-6 rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
        <div>
            <h2 class="text-lg font-bold text-gray-900">
                Profile Completion
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                @if ($completionPercentage <= 49)
                    Complete your profile so other alumni can know you better.
                @elseif ($completionPercentage <= 79)
                    Your profile is almost complete. Add the missing details to improve visibility.
                @elseif ($completionPercentage <= 99)
                    Great progress. Add the remaining details to complete your profile.
                @else
                    Your profile is complete.
                @endif
            </p>
        </div>

        <div class="shrink-0 rounded-full bg-[#6B0F1A]/10 px-4 py-2 text-sm font-bold text-[#6B0F1A]">
            {{ $completionPercentage }}%
        </div>
    </div>

    <div class="mt-5">
        <div class="flex items-center justify-between text-sm">
            <span class="font-medium text-gray-700">
                Profile Completion
            </span>

            <span class="font-semibold text-gray-900">
                {{ $completionPercentage }}%
            </span>
        </div>

        <div class="mt-2 h-3 w-full overflow-hidden rounded-full bg-gray-100">
            <div
                class="h-full rounded-full transition-all duration-300 {{ $completionPercentage === 100 ? 'bg-green-600' : 'bg-[#6B0F1A]' }}"
                style="width: {{ $completionPercentage }}%;"
            ></div>
        </div>
    </div>

    <div class="mt-5">
        @if ($completionPercentage === 100)
            <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-700">
                Your profile is complete. Other alumni can now view your full information.
            </div>
        @else
            <p class="text-sm font-medium text-gray-700">
                Missing fields:
            </p>

            <div class="mt-3 flex flex-wrap gap-2">
                @foreach ($missingFields as $field)
                    <span class="rounded-full border border-gray-200 bg-gray-50 px-3 py-1 text-xs font-semibold text-gray-700">
                        {{ $field }}
                    </span>
                @endforeach
            </div>
        @endif
    </div>
</div>

        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
            <form method="POST" action="{{ route('alumni.profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                    <div class="h-24 w-24 overflow-hidden rounded-full border border-gray-200 bg-gray-100">
                        @if ($profile && $profile->profile_picture)
                            <img
                                src="{{ asset('storage/' . $profile->profile_picture) }}"
                                alt="Profile picture"
                                class="h-full w-full object-cover"
                            >
                        @else
                            <div class="flex h-full w-full items-center justify-center text-2xl font-bold text-gray-400">
                                {{ strtoupper(substr(auth()->user()->first_name, 0, 1)) }}
                            </div>
                        @endif
                    </div>

                    <div class="flex-1">
                        <x-input-label for="profile_picture" :value="__('Profile Picture')" />

                        <input
                            id="profile_picture"
                            type="file"
                            name="profile_picture"
                            accept="image/png,image/jpeg,image/jpg"
                            class="mt-1 block w-full text-sm text-gray-700 file:mr-4 file:rounded-lg file:border-0 file:bg-[#6B0F1A] file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-[#4A0A12]"
                        >

                        <p class="mt-1 text-xs text-gray-500">
                            Accepted formats: JPG, JPEG, PNG. Max size: 2MB.
                        </p>

                        <x-input-error :messages="$errors->get('profile_picture')" class="mt-2" />
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                    <div>
                        <x-input-label for="contact_number" :value="__('Contact Number')" />
                        <x-text-input id="contact_number" name="contact_number" type="text" class="mt-1 block w-full" :value="old('contact_number', $profile->contact_number ?? '')" />
                        <x-input-error :messages="$errors->get('contact_number')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="graduation_year" :value="__('Graduation Year')" />
                        <x-text-input id="graduation_year" name="graduation_year" type="number" class="mt-1 block w-full" :value="old('graduation_year', $profile->graduation_year ?? '')" />
                        <x-input-error :messages="$errors->get('graduation_year')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="program" :value="__('Program')" />
                        <x-text-input id="program" name="program" type="text" class="mt-1 block w-full" :value="old('program', $profile->program ?? '')" />
                        <x-input-error :messages="$errors->get('program')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="company" :value="__('Company')" />
                        <x-text-input id="company" name="company" type="text" class="mt-1 block w-full" :value="old('company', $profile->company ?? '')" />
                        <x-input-error :messages="$errors->get('company')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="location" :value="__('Location')" />
                        <x-text-input id="location" name="location" type="text" class="mt-1 block w-full" :value="old('location', $profile->location ?? '')" />
                        <x-input-error :messages="$errors->get('location')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="job_title" :value="__('Job Title')" />
                        <x-text-input id="job_title" name="job_title" type="text" class="mt-1 block w-full" :value="old('job_title', $profile->job_title ?? '')" />
                        <x-input-error :messages="$errors->get('job_title')" class="mt-2" />
                    </div>
                </div>

                <div>
                    <x-input-label for="skills" :value="__('Skills')" />

                    <textarea
                        id="skills"
                        name="skills"
                        rows="4"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#6B0F1A] focus:ring-[#6B0F1A]"
                    >{{ old('skills', $profile->skills ?? '') }}</textarea>

                    <x-input-error :messages="$errors->get('skills')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end gap-3 border-t border-gray-100 pt-5">
                    <a
                        href="{{ route('alumni.dashboard') }}"
                        class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50"
                    >
                        Cancel
                    </a>

                    <button
                        type="submit"
                        class="inline-flex items-center rounded-lg bg-[#6B0F1A] px-4 py-2 text-sm font-semibold text-white hover:bg-[#4A0A12] focus:outline-none focus:ring-2 focus:ring-[#6B0F1A] focus:ring-offset-2"
                    >
                        Save Profile
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>