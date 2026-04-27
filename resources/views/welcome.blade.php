<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>STCTI Alumni Management System</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-900 antialiased">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="sticky top-0 z-50 border-b border-gray-200 bg-white/95 backdrop-blur">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4 lg:px-8">
                <a href="{{ route('landing') }}" class="flex items-center gap-3">
                    <div class="flex h-12 w-12 items-center justify-center overflow-hidden rounded-full border border-gray-200 bg-white p-1.5 shadow-sm">
                        <img
                            src="{{ asset('images/stcti-logo.png') }}"
                            alt="STCTI Logo"
                            class="h-full w-full object-contain"
                        >
                    </div>

                    <div>
                        <p class="text-sm font-bold uppercase tracking-wide text-[#6B0F1A]">
                            STCTI
                        </p>
                        <p class="text-xs font-medium text-gray-600">
                            Alumni Management System
                        </p>
                    </div>
                </a>

                <nav class="hidden items-center gap-8 md:flex">
                    <a href="#about" class="text-sm font-medium text-gray-600 hover:text-[#6B0F1A]">
                        About
                    </a>

                    <a href="#features" class="text-sm font-medium text-gray-600 hover:text-[#6B0F1A]">
                        Features
                    </a>

                    <a href="#purpose" class="text-sm font-medium text-gray-600 hover:text-[#6B0F1A]">
                        Purpose
                    </a>
                </nav>

                <div class="flex items-center gap-3">
                    <a
                        href="{{ route('alumni.login')}}"
                        class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50"
                    >
                        Log In
                    </a>

                    @if (Route::has('register'))
                        <a
                            href="{{ route('register') }}"
                            class="rounded-lg bg-[#6B0F1A] px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-[#4A0A12]"
                        >
                            Register
                        </a>
                    @endif
                </div>
            </div>
        </header>

        <main>
            <!-- Hero Section -->
            <section class="relative overflow-hidden bg-white">
                <div
                    class="absolute inset-0 bg-cover bg-center bg-no-repeat"
                    style="background-image: url('{{ asset('images/auth/school-bg.jpg') }}');"
                ></div>

                <div class="absolute inset-0 bg-white/85"></div>

                <div class="absolute inset-y-0 right-0 hidden w-1/2 bg-[#6B0F1A]/95 lg:block"></div>

                <div class="relative mx-auto grid max-w-7xl grid-cols-1 lg:grid-cols-2">
                    <div class="px-6 py-20 lg:px-8 lg:py-28">
                        <div class="max-w-xl">
                            <span class="inline-flex rounded-full border border-[#6B0F1A]/20 bg-[#6B0F1A]/10 px-4 py-1 text-xs font-bold uppercase tracking-wide text-[#6B0F1A]">
                                Saint Theresa College of Tandag, Incorporated
                            </span>

                            <h1 class="mt-6 text-4xl font-extrabold tracking-tight text-gray-950 sm:text-5xl">
                                Connect. Engage. Support the STCTI Alumni Community.
                            </h1>

                            <p class="mt-5 text-base leading-8 text-gray-600">
                                The STCTI Alumni Management System provides a secure and organized platform for alumni records,
                                alumni networking, career opportunities, events, donations, and official announcements.
                            </p>

                            <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                                <a
                                    href="{{route('alumni.login') }}"
                                    class="inline-flex items-center justify-center rounded-lg bg-[#6B0F1A] px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-[#4A0A12]"
                                >
                                    Access Your Account
                                </a>

                                @if (Route::has('register'))
                                    <a
                                        href="{{ route('register') }}"
                                        class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-6 py-3 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50"
                                    >
                                        Register as Alumni
                                    </a>
                                @endif
                            </div>

                            <p class="mt-4 text-xs text-gray-500">
                                For account access concerns, please contact the system administrator.
                            </p>
                        </div>
                    </div>

                    <div class="relative bg-[#6B0F1A] px-6 py-16 lg:px-8 lg:py-28">
                        <div
                            class="absolute inset-0 bg-cover bg-center bg-no-repeat opacity-20"
                            style="background-image: url('{{ asset('images/auth/school-bg.jpg') }}');"
                        ></div>

                        <div class="absolute inset-0 bg-gradient-to-br from-[#6B0F1A] via-[#7B1220]/95 to-[#4A0A12]"></div>

                        <div class="relative mx-auto max-w-md rounded-3xl border border-white/15 bg-white/10 p-8 text-white shadow-2xl backdrop-blur">
                            <div class="mx-auto flex h-32 w-32 items-center justify-center overflow-hidden rounded-full bg-white p-3 shadow-lg">
                                <img
                                    src="{{ asset('images/stcti-logo.png') }}"
                                    alt="STCTI Logo"
                                    class="h-full w-full object-contain"
                                >
                            </div>

                            <div class="mt-8 text-center">
                                <h2 class="text-2xl font-bold">
                                    STCTI Alumni Management System
                                </h2>

                                <p class="mt-3 text-sm leading-6 text-white/80">
                                    A formal platform for strengthening alumni connections, managing institutional records,
                                    and supporting alumni engagement.
                                </p>
                            </div>

                            <div class="mt-8 grid grid-cols-3 gap-3 text-center">
                                <div class="rounded-xl bg-white/10 p-4">
                                    <p class="text-lg font-bold">Secure</p>
                                    <p class="mt-1 text-xs text-white/70">Role-based access</p>
                                </div>

                                <div class="rounded-xl bg-white/10 p-4">
                                    <p class="text-lg font-bold">Formal</p>
                                    <p class="mt-1 text-xs text-white/70">Academic design</p>
                                </div>

                                <div class="rounded-xl bg-white/10 p-4">
                                    <p class="text-lg font-bold">Unified</p>
                                    <p class="mt-1 text-xs text-white/70">One system</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- About -->
            <section id="about" class="border-t border-gray-200 bg-gray-50 py-16">
                <div class="mx-auto max-w-7xl px-6 lg:px-8">
                    <div class="mx-auto max-w-3xl text-center">
                        <h2 class="text-3xl font-bold tracking-tight text-gray-950">
                            About the System
                        </h2>

                        <p class="mt-4 text-base leading-8 text-gray-600">
                            This system is designed to help Saint Theresa College of Tandag, Incorporated manage alumni-related
                            information in a structured, secure, and user-friendly way. It supports both administrative management
                            and alumni participation through a role-based platform.
                        </p>
                    </div>
                </div>
            </section>

            <!-- Features -->
            <section id="features" class="bg-white py-16">
                <div class="mx-auto max-w-7xl px-6 lg:px-8">
                    <div class="max-w-3xl">
                        <h2 class="text-3xl font-bold tracking-tight text-gray-950">
                            Main Features
                        </h2>

                        <p class="mt-4 text-base leading-8 text-gray-600">
                            The platform provides essential tools for alumni engagement, communication, and record management.
                        </p>
                    </div>

                    <div class="mt-10 grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                            <h3 class="text-lg font-bold text-gray-900">
                                Alumni Profiles
                            </h3>

                            <p class="mt-2 text-sm leading-6 text-gray-600">
                                Alumni can maintain their profile, academic details, career information, and skills.
                            </p>
                        </div>

                        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                            <h3 class="text-lg font-bold text-gray-900">
                                Opportunities
                            </h3>

                            <p class="mt-2 text-sm leading-6 text-gray-600">
                                Alumni can view approved job opportunities and submit opportunities for admin review.
                            </p>
                        </div>

                        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                            <h3 class="text-lg font-bold text-gray-900">
                                Events
                            </h3>

                            <p class="mt-2 text-sm leading-6 text-gray-600">
                                Alumni can view approved events and submit event proposals for review.
                            </p>
                        </div>

                        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                            <h3 class="text-lg font-bold text-gray-900">
                                Donations
                            </h3>

                            <p class="mt-2 text-sm leading-6 text-gray-600">
                                Alumni can submit donation records while admins verify and manage donation information.
                            </p>
                        </div>

                        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                            <h3 class="text-lg font-bold text-gray-900">
                                Announcements
                            </h3>

                            <p class="mt-2 text-sm leading-6 text-gray-600">
                                Official updates and announcements can be published for alumni users.
                            </p>
                        </div>

                        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                            <h3 class="text-lg font-bold text-gray-900">
                                Notifications
                            </h3>

                            <p class="mt-2 text-sm leading-6 text-gray-600">
                                Users receive system updates for approvals, submissions, donations, and announcements.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Purpose -->
            <section id="purpose" class="bg-gray-50 py-16">
                <div class="mx-auto max-w-7xl px-6 lg:px-8">
                    <div class="grid grid-cols-1 gap-8 lg:grid-cols-2 lg:items-center">
                        <div>
                            <h2 class="text-3xl font-bold tracking-tight text-gray-950">
                                Built for Alumni Engagement and Institutional Organization
                            </h2>

                            <p class="mt-4 text-base leading-8 text-gray-600">
                                The system helps organize alumni information, simplify communication, support event management,
                                and provide alumni with access to opportunities and updates from the institution.
                            </p>
                        </div>

                        <div class="rounded-3xl border border-gray-200 bg-white p-8 shadow-sm">
                            <div class="space-y-5">
                                <div class="flex gap-4">
                                    <div class="mt-1 h-3 w-3 shrink-0 rounded-full bg-[#6B0F1A]"></div>
                                    <p class="text-sm leading-6 text-gray-700">
                                        Strengthens communication between STCTI and its alumni community.
                                    </p>
                                </div>

                                <div class="flex gap-4">
                                    <div class="mt-1 h-3 w-3 shrink-0 rounded-full bg-[#6B0F1A]"></div>
                                    <p class="text-sm leading-6 text-gray-700">
                                        Provides a centralized platform for profiles, events, donations, and announcements.
                                    </p>
                                </div>

                                <div class="flex gap-4">
                                    <div class="mt-1 h-3 w-3 shrink-0 rounded-full bg-[#6B0F1A]"></div>
                                    <p class="text-sm leading-6 text-gray-700">
                                        Supports role-based access for secure administration and alumni participation.
                                    </p>
                                </div>

                                <div class="flex gap-4">
                                    <div class="mt-1 h-3 w-3 shrink-0 rounded-full bg-[#6B0F1A]"></div>
                                    <p class="text-sm leading-6 text-gray-700">
                                        Helps preserve alumni records and improve alumni engagement activities.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- CTA -->
            <section class="bg-[#6B0F1A] py-16">
                <div class="mx-auto max-w-4xl px-6 text-center lg:px-8">
                    <h2 class="text-3xl font-bold tracking-tight text-white">
                        Access the STCTI Alumni Management System
                    </h2>

                    <p class="mt-4 text-base leading-8 text-white/80">
                        Log in to manage your profile, view opportunities, check events, submit donations, and stay updated with official announcements.
                    </p>

                    <div class="mt-8 flex flex-col justify-center gap-3 sm:flex-row">
                        <a
                            href="{{ route('alumni.login') }}"
                            class="inline-flex items-center justify-center rounded-lg bg-white px-6 py-3 text-sm font-semibold text-[#6B0F1A] shadow-sm hover:bg-gray-100"
                        >
                            Log In
                        </a>

                        @if (Route::has('register'))
                            <a
                                href="{{ route('register') }}"
                                class="inline-flex items-center justify-center rounded-lg border border-white/30 px-6 py-3 text-sm font-semibold text-white hover:bg-white/10"
                            >
                                Register
                            </a>
                        @endif
                    </div>
                </div>
            </section>
        </main>

        <!-- Footer -->
<footer class="border-t border-gray-200 bg-white">
    <div class="mx-auto flex max-w-7xl flex-col gap-3 px-6 py-6 text-sm text-gray-500 sm:flex-row sm:items-center sm:justify-between lg:px-8">
        <p>
            © {{ date('Y') }} Saint Theresa College of Tandag, Incorporated. All rights reserved.
        </p>

        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:gap-4">
            <p>
                STCTI Alumni Management System
            </p>

            <a
                href="{{ route('admin.login') }}"
                class="font-medium text-gray-500 hover:text-[#6B0F1A] hover:underline"
            >
                Admin Login
            </a>
        </div>
    </div>
</footer>
    </div>
</body>
</html>