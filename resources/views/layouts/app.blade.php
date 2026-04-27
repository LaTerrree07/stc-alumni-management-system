<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'STCTI Alumni Management System') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-50 text-gray-900">
    <div
        x-data="{ sidebarOpen: false }"
        class="min-h-screen"
    >
        <!-- Mobile Overlay -->
        <div
            x-show="sidebarOpen"
            x-transition.opacity
            class="fixed inset-0 z-40 bg-black/40 lg:hidden"
            @click="sidebarOpen = false"
        ></div>

        <!-- Sidebar -->
        @include('layouts.sidebar')

        <!-- Main Content -->
        <div class="lg:pl-64">
            <!-- Mobile Header -->
            <header class="sticky top-0 z-30 flex items-center justify-between bg-white border-b border-gray-200 px-4 py-3 lg:hidden">
                <button
                    type="button"
                    class="inline-flex items-center justify-center rounded-lg p-2 text-gray-600 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#6B0F1A]"
                    @click="sidebarOpen = true"
                    aria-label="Open sidebar menu"
                >
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <div class="flex items-center gap-2">
                    <img
                        src="{{ asset('images/stcti-logo.png') }}"
                        alt="STCTI Logo"
                        class="h-9 w-9 object-contain"
                    >

                    <span class="text-sm font-bold text-gray-900">
                        STCTI AMS
                    </span>
                </div>
            </header>

            <!-- Page Content -->
            <main class="min-h-screen px-4 py-6 sm:px-6 lg:px-8">
                {{ $slot }}
            </main> 
        </div>
    </div>
   <x-flash-modal id="globalFlashModal" />
<x-confirm-modal id="globalConfirmModal" />
</body>
</html>