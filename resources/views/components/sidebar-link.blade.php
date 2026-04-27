@props([
    'href' => '#',
    'active' => false,
    'label' => '',
    'icon' => 'circle',
])

<a
    href="{{ $href }}"
    class="group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition
    {{ $active ? 'bg-white text-[#6B0F1A] shadow-sm' : 'text-white/80 hover:bg-white/10 hover:text-white' }}"
>
    <span class="h-5 w-5 shrink-0">
        @switch($icon)
            @case('dashboard')
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h3.75c.621 0 1.125.504 1.125 1.125v6.75C9 20.496 8.496 21 7.875 21h-3.75A1.125 1.125 0 013 19.875v-6.75zM9.75 4.125C9.75 3.504 10.254 3 10.875 3h2.25c.621 0 1.125.504 1.125 1.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125zM15 8.625C15 8.004 15.504 7.5 16.125 7.5h3.75c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-3.75A1.125 1.125 0 0115 19.875V8.625z" />
                </svg>
                @break

            @case('users')
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.75.78 3.75 3.75 0 00-7.5 0 9.094 9.094 0 003.75-.78zM6 18.72a9.094 9.094 0 013.75.78 3.75 3.75 0 01-7.5 0A9.094 9.094 0 006 18.72zM15 6.75a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                @break

            @case('user')
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 7.5a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.25a8.25 8.25 0 0115 0" />
                </svg>
                @break

            @case('network')
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 12a4.5 4.5 0 109 0 4.5 4.5 0 00-9 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h.008v.008H3.75V6.75zm16.5 0h.008v.008h-.008V6.75zm0 10.5h.008v.008h-.008v-.008zm-16.5 0h.008v.008H3.75v-.008zM7.5 12H3.75m16.5 0H16.5M12 7.5V3.75m0 16.5V16.5" />
                </svg>
                @break

            @case('briefcase')
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.1A2.25 2.25 0 0118 20.5H6a2.25 2.25 0 01-2.25-2.25v-4.1m16.5 0A2.25 2.25 0 0018 11.9H6a2.25 2.25 0 00-2.25 2.25m16.5 0V8.25A2.25 2.25 0 0018 6h-3.75V4.5A1.5 1.5 0 0012.75 3h-1.5a1.5 1.5 0 00-1.5 1.5V6H6a2.25 2.25 0 00-2.25 2.25v5.9" />
                </svg>
                @break

            @case('calendar')
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25m10.5-2.25v2.25M3.75 8.25h16.5M4.5 6h15A1.5 1.5 0 0121 7.5v12A1.5 1.5 0 0119.5 21h-15A1.5 1.5 0 013 19.5v-12A1.5 1.5 0 014.5 6z" />
                </svg>
                @break

            @case('fund')
            @case('donation')
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m3-9.75A3 3 0 009 8.25c0 1.657 1.343 2.25 3 2.25s3 .593 3 2.25S13.657 15.75 12 15.75a3 3 0 01-3-3M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                @break

            @case('megaphone')
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84L5.5 14.5A2 2 0 014 12.57v-1.14a2 2 0 011.5-1.93l4.84-1.34L19.5 4.5v15l-9.16-3.66zM7.5 15l1.5 4.5" />
                </svg>
                @break

            @case('bell')
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a3 3 0 01-5.714 0" />
                </svg>
                @break

            @case('settings')
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317a1.724 1.724 0 013.35 0 1.724 1.724 0 002.573 1.066 1.724 1.724 0 012.37 2.37 1.724 1.724 0 001.065 2.572 1.724 1.724 0 010 3.35 1.724 1.724 0 00-1.066 2.573 1.724 1.724 0 01-2.37 2.37 1.724 1.724 0 00-2.572 1.065 1.724 1.724 0 01-3.35 0 1.724 1.724 0 00-2.573-1.066 1.724 1.724 0 01-2.37-2.37 1.724 1.724 0 00-1.065-2.572 1.724 1.724 0 010-3.35 1.724 1.724 0 001.066-2.573 1.724 1.724 0 012.37-2.37 1.724 1.724 0 002.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                @break

            @default
                <svg fill="currentColor" viewBox="0 0 20 20">
                    <circle cx="10" cy="10" r="4" />
                </svg>
        @endswitch
    </span>

    <span class="truncate">
        {{ $label }}
    </span>
</a>