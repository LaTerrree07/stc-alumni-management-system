@props([
    'title' => 'Summary',
    'value' => '0',
    'icon' => null,
    'href' => null,
    'variant' => 'primary',
])

@php
    $variantClasses = [
        'primary' => 'border-[#6B0F1A]/20 bg-white text-[#6B0F1A]',
        'success' => 'border-green-200 bg-white text-green-700',
        'warning' => 'border-amber-200 bg-white text-amber-700',
        'info' => 'border-blue-200 bg-white text-blue-700',
        'neutral' => 'border-gray-200 bg-white text-gray-700',
    ];

    $cardClass = $variantClasses[$variant] ?? $variantClasses['primary'];

    $titleLower = strtolower($title);

    if (! $icon) {
        if (str_contains($titleLower, 'alumni')) {
            $icon = 'users';
        } elseif (str_contains($titleLower, 'job')) {
            $icon = 'briefcase';
        } elseif (str_contains($titleLower, 'event')) {
            $icon = 'calendar';
        } elseif (str_contains($titleLower, 'donation') || str_contains($titleLower, 'fund')) {
            $icon = 'money';
        } elseif (str_contains($titleLower, 'announcement')) {
            $icon = 'megaphone';
        } elseif (str_contains($titleLower, 'notification')) {
            $icon = 'bell';
        } elseif (str_contains($titleLower, 'pending')) {
            $icon = 'clock';
        } elseif (str_contains($titleLower, 'approved') || str_contains($titleLower, 'verified') || str_contains($titleLower, 'published')) {
            $icon = 'check';
        } else {
            $icon = 'chart';
        }
    }
@endphp

@php
    $cardContent = '
        <div class="flex min-h-32 flex-col justify-between rounded-xl border p-6 shadow-sm transition hover:shadow-md ' . $cardClass . '">
            <div class="flex items-start justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-gray-50 text-current">
    ';
@endphp

@if ($href)
    <a href="{{ $href }}" class="block rounded-xl focus:outline-none focus:ring-2 focus:ring-[#6B0F1A] focus:ring-offset-2">
@endif

<div class="flex min-h-32 flex-col justify-between rounded-xl border p-6 shadow-sm transition hover:shadow-md {{ $cardClass }}">
    <div class="flex items-start justify-between gap-3">
        <div class="flex items-center gap-3">
            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-gray-50 text-current">
                @switch($icon)
                    @case('users')
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 003.75.747 9.337 9.337 0 003.75-.747M15 19.128a9.337 9.337 0 01-7.5 0M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M7.5 19.128v-.003c0-1.113.285-2.16.786-3.07M15 11.25a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        @break

                    @case('briefcase')
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.35A2.25 2.25 0 0118 20.75H6a2.25 2.25 0 01-2.25-2.25v-4.35M16.5 6.75V5.25A2.25 2.25 0 0014.25 3h-4.5A2.25 2.25 0 007.5 5.25v1.5M3.75 8.25h16.5v4.5A2.25 2.25 0 0118 15H6a2.25 2.25 0 01-2.25-2.25v-4.5z" />
                        </svg>
                        @break

                    @case('calendar')
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 5.25h13.5A1.5 1.5 0 0120.25 6.75v12A1.5 1.5 0 0118.75 20.25H5.25A1.5 1.5 0 013.75 18.75v-12A1.5 1.5 0 015.25 5.25z" />
                        </svg>
                        @break

                    @case('money')
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5v7.5H2.25v-7.5z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 12h.01M18 12h.01M12 14.25a2.25 2.25 0 100-4.5 2.25 2.25 0 000 4.5z" />
                        </svg>
                        @break

                    @case('megaphone')
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84L5.5 14.5A2 2 0 014 12.57v-1.14a2 2 0 011.5-1.93l4.84-1.34L19.5 4.5v15l-9.16-3.66zM7.5 15l1.5 4.5" />
                        </svg>
                        @break

                    @case('bell')
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.25 18.75a2.25 2.25 0 01-4.5 0M18 9.75a6 6 0 10-12 0c0 7.5-3 7.5-3 7.5h18s-3 0-3-7.5z" />
                        </svg>
                        @break

                    @case('clock')
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        @break

                    @case('check')
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                        </svg>
                        @break

                    @default
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 19.5h16.5M6.75 16.5v-6M12 16.5v-9M17.25 16.5v-12" />
                        </svg>
                @endswitch
            </div>

            <p class="text-sm font-medium text-gray-500">
                {{ $title }}
            </p>
        </div>
    </div>

    <div class="mt-6 text-right">
        <p class="text-2xl font-bold text-gray-900">
            {{ $value }}
        </p>
    </div>
</div>

@if ($href)
    </a>
@endif