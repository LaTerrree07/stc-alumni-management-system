<x-guest-layout>
    <a
        href="{{ route('landing') }}"
        class="fixed right-4 top-4 z-50 inline-flex items-center gap-2 rounded-full border border-gray-200 bg-white/90 px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm backdrop-blur transition hover:bg-white hover:text-[#6B0F1A]"
    >
        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
        </svg>

        Back to Home
    </a>

    <div class="mb-8">
        <p class="text-sm font-bold uppercase tracking-wide text-[#6B0F1A]">
            Alumni Registration
        </p>

        <h1 class="mt-2 text-3xl font-bold text-gray-900">
            Create your alumni account
        </h1>

        <p class="mt-2 text-sm text-gray-600">
            Register to access alumni services, opportunities, events, donations, and announcements.
        </p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <div class="grid grid-cols-1 gap-5 md:grid-cols-3">
            <div>
                <x-input-label for="first_name" :value="__('First Name')" />

                <x-text-input
                    id="first_name"
                    name="first_name"
                    type="text"
                    class="mt-1 block w-full"
                    :value="old('first_name')"
                    required
                    autofocus
                    autocomplete="given-name"
                />

                <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="middle_name" :value="__('Middle Name')" />

                <x-text-input
                    id="middle_name"
                    name="middle_name"
                    type="text"
                    class="mt-1 block w-full"
                    :value="old('middle_name')"
                    autocomplete="additional-name"
                />

                <x-input-error :messages="$errors->get('middle_name')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="last_name" :value="__('Last Name')" />

                <x-text-input
                    id="last_name"
                    name="last_name"
                    type="text"
                    class="mt-1 block w-full"
                    :value="old('last_name')"
                    required
                    autocomplete="family-name"
                />

                <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
            </div>
        </div>

        <div>
            <x-input-label for="email" :value="__('Email Address')" />

            <x-text-input
                id="email"
                name="email"
                type="email"
                class="mt-1 block w-full"
                :value="old('email')"
                required
                autocomplete="username"
            />

            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Password')" />

            <x-password-input
                id="password"
                name="password"
                class="mt-1"
                required
                autocomplete="new-password"
            />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-password-input
                id="password_confirmation"
                name="password_confirmation"
                class="mt-1"
                required
                autocomplete="new-password"
            />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex flex-col gap-3 border-t border-gray-100 pt-5 sm:flex-row sm:items-center sm:justify-between">
            <a
                href="{{ route('alumni.login') }}"
                class="text-sm font-semibold text-[#6B0F1A] hover:underline"
            >
                Already registered?
            </a>

            <button
                type="submit"
                class="rounded-lg bg-[#6B0F1A] px-4 py-3 text-sm font-bold uppercase tracking-wide text-white shadow-sm transition hover:bg-[#4A0A12] focus:outline-none focus:ring-2 focus:ring-[#6B0F1A] focus:ring-offset-2"
            >
                Register
            </button>
        </div>
    </form>
</x-guest-layout>