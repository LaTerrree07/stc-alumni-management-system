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

    <div class="mb-6">
        <p class="text-sm font-bold uppercase tracking-wide text-[#6B0F1A]">
            Account Recovery
        </p>

        <h1 class="mt-2 text-2xl font-bold text-gray-900">
            Reset Password
        </h1>

        <p class="mt-1 text-sm text-gray-600">
            Enter your email address and create a new password for your account.
        </p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email Address')" />

            <x-text-input
                id="email"
                name="email"
                type="email"
                class="mt-1 block w-full"
                :value="old('email', $request->email)"
                required
                autofocus
                autocomplete="username"
            />

            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('New Password')" />

            <x-password-input
                id="password"
                name="password"
                class="mt-1"
                required
                autocomplete="new-password"
            />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm New Password')" />

            <x-password-input
                id="password_confirmation"
                name="password_confirmation"
                class="mt-1"
                required
                autocomplete="new-password"
            />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end border-t border-gray-100 pt-5">
            <button
                type="submit"
                class="rounded-lg bg-[#6B0F1A] px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-[#4A0A12] focus:outline-none focus:ring-2 focus:ring-[#6B0F1A] focus:ring-offset-2"
            >
                Reset Password
            </button>
        </div>
    </form>
</x-guest-layout>