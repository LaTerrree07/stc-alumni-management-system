<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Alumni Login | STCTI Alumni Management System</title>

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
                        Alumni Management System
                    </p>

                    <p class="mt-6 max-w-lg text-base leading-8 text-white/85">
                        A secure platform for alumni profiles, opportunities, events, donations,
                        announcements, and alumni network management.
                    </p>
                </div>
            </div>
        </div>

        <!-- Right Login Panel -->
        <div class="flex min-h-screen items-center justify-center bg-white px-6 py-16 lg:px-12">
            <div class="w-full max-w-md">
                <div class="mb-10 flex items-center gap-4">
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
                        Alumni Access
                    </p>

                    <h2 class="mt-3 text-4xl font-extrabold tracking-tight text-gray-950">
                        Sign in to your account
                    </h2>

                    <p class="mt-3 text-sm leading-6 text-gray-600">
                        Enter your alumni email and password to access alumni services.
                    </p>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('alumni.login.store') }}" class="space-y-5">
                    @csrf

                    <div>
                        <x-input-label for="email" :value="__('Email Address')" />

                        <x-text-input
                            id="email"
                            class="mt-1 block w-full"
                            type="email"
                            name="email"
                            :value="old('email')"
                            required
                            autofocus
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
                            autocomplete="current-password"
                        />

                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-between">
                        <label for="remember_me" class="inline-flex items-center">
                            <input
                                id="remember_me"
                                type="checkbox"
                                class="rounded border-gray-300 text-[#6B0F1A] shadow-sm focus:ring-[#6B0F1A]"
                                name="remember"
                            >

                            <span class="ms-2 text-sm text-gray-600">
                                Remember me
                            </span>
                        </label>

                        @if (Route::has('password.request'))
                            <a
                                class="text-sm font-semibold text-[#6B0F1A] hover:underline"
                                href="{{ route('password.request') }}"
                            >
                                Forgot password?
                            </a>
                        @endif
                    </div>

                    <button
                        type="submit"
                        class="w-full rounded-lg bg-[#6B0F1A] px-4 py-3 text-sm font-bold uppercase tracking-wide text-white shadow-sm transition hover:bg-[#4A0A12] focus:outline-none focus:ring-2 focus:ring-[#6B0F1A] focus:ring-offset-2"
                    >
                        Log In as Alumni
                    </button>

                    <div class="space-y-2 text-center text-sm text-gray-600">
                        <p>
                            Admin user?
                            <a href="{{ route('admin.login') }}" class="font-semibold text-[#6B0F1A] hover:underline">
                                Go to Admin Login
                            </a>
                        </p>

                        @if (Route::has('register'))
                            <p>
                                Don’t have an account?
                                <a href="{{ route('register') }}" class="font-semibold text-[#6B0F1A] hover:underline">
                                    Register here
                                </a>
                            </p>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>