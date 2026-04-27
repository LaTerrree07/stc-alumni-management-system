<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Alumni Registration | STCTI Alumni Management System</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-900 antialiased">
    <div class="min-h-screen lg:grid lg:grid-cols-2">
        <a
            href="{{ route('landing') }}"
            class="fixed right-4 top-4 z-50 inline-flex items-center gap-2 rounded-full border border-gray-200 bg-white/90 px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm backdrop-blur transition hover:bg-white hover:text-[#6B0F1A]"
        >
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>

            Back to Home
        </a>

        <!-- Left Branding Panel -->
        <div class="relative hidden overflow-hidden bg-[#6B0F1A] lg:block">
            <div
                class="absolute inset-0 bg-cover bg-center bg-no-repeat opacity-45"
                style="background-image: url('{{ asset('images/auth/stcti-login-bg.jpg') }}');"
            ></div>

            <div class="absolute inset-0 bg-gradient-to-br from-[#6B0F1A]/85 via-[#7B1220]/75 to-[#4A0A12]/85"></div>

            <div class="relative flex h-full items-center px-16">
                <div class="max-w-xl text-white">
                    <div class="flex h-24 w-24 items-center justify-center overflow-hidden rounded-full bg-white p-3 shadow-lg">
                        <img
                            src="{{ asset('images/stcti-logo.png') }}"
                            alt="STCTI Logo"
                            class="h-full w-full object-contain"
                        >
                    </div>

                    <h1 class="mt-10 text-5xl font-extrabold leading-tight">
                        Saint Theresa College of Tandag, Incorporated
                    </h1>

                    <p class="mt-6 text-2xl font-semibold text-white/95">
                        Alumni Registration
                    </p>

                    <p class="mt-6 max-w-lg text-base leading-8 text-white/85">
                        Create your alumni account to access alumni services, opportunities,
                        events, donations, announcements, and alumni network features.
                    </p>
                </div>
            </div>
        </div>

        <!-- Right Registration Panel -->
        <div class="flex min-h-screen items-center justify-center bg-white px-6 py-16 lg:px-12">
            <div class="w-full max-w-xl">
                <div class="mb-8 flex items-center gap-4">
                    <div class="flex h-16 w-16 items-center justify-center overflow-hidden rounded-full bg-white p-1.5 shadow-sm ring-1 ring-gray-200">
                        <img
                            src="{{ asset('images/stcti-logo.png') }}"
                            alt="STCTI Logo"
                            class="h-full w-full object-contain"
                        >
                    </div>

                    <div>
                        <p class="text-base font-bold text-gray-900">
                            STCTI
                        </p>

                        <p class="text-sm text-gray-500">
                            Alumni Management System
                        </p>
                    </div>
                </div>

                <div class="mb-8">
                    <p class="text-sm font-bold uppercase tracking-wide text-[#6B0F1A]">
                        Alumni Registration
                    </p>

                    <h2 class="mt-3 text-4xl font-extrabold tracking-tight text-gray-950">
                        Create your alumni account
                    </h2>

                    <p class="mt-3 text-sm leading-6 text-gray-600">
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
                                class="mt-1 block w-full"
                                type="text"
                                name="first_name"
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
                                class="mt-1 block w-full"
                                type="text"
                                name="middle_name"
                                :value="old('middle_name')"
                                autocomplete="additional-name"
                            />

                            <x-input-error :messages="$errors->get('middle_name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="last_name" :value="__('Last Name')" />

                            <x-text-input
                                id="last_name"
                                class="mt-1 block w-full"
                                type="text"
                                name="last_name"
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
                            class="mt-1 block w-full"
                            type="email"
                            name="email"
                            :value="old('email')"
                            required
                            autocomplete="username"
                        />

                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
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
                            class="rounded-lg bg-[#6B0F1A] px-5 py-3 text-sm font-bold uppercase tracking-wide text-white shadow-sm transition hover:bg-[#4A0A12] focus:outline-none focus:ring-2 focus:ring-[#6B0F1A] focus:ring-offset-2"
                        >
                            Register
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>