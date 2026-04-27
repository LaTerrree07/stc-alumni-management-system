@props([
    'icon' => 'eye',
])

<span class="h-4 w-4">
    @switch($icon)
        @case('eye')
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12 18 18.75 12 18.75 2.25 12 2.25 12z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            @break

        @case('pencil')
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897L16.862 4.487z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 7.125L16.875 4.5" />
            </svg>
            @break

        @case('check')
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
            </svg>
            @break

        @case('x')
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
            @break

        @case('archive')
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 7.5h16.5M5.25 7.5v11.25A2.25 2.25 0 007.5 21h9a2.25 2.25 0 002.25-2.25V7.5M9 11.25h6M4.5 3.75h15a.75.75 0 01.75.75v3h-16.5v-3a.75.75 0 01.75-.75z" />
            </svg>
            @break

        @case('trash')
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 7.5h12M9.75 7.5V5.25A1.5 1.5 0 0111.25 3.75h1.5a1.5 1.5 0 011.5 1.5V7.5M8.25 7.5l.75 12A1.5 1.5 0 0010.5 21h3a1.5 1.5 0 001.5-1.5l.75-12" />
            </svg>
            @break

        @case('shield-check')
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3.75l7.5 3v5.25c0 4.5-3.075 8.7-7.5 9.75-4.425-1.05-7.5-5.25-7.5-9.75V6.75l7.5-3z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75l2.25 2.25L15.75 9.75" />
            </svg>
            @break

        @case('megaphone')
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84L5.5 14.5A2 2 0 014 12.57v-1.14a2 2 0 011.5-1.93l4.84-1.34L19.5 4.5v15l-9.16-3.66zM7.5 15l1.5 4.5" />
            </svg>
            @break

        @case('arrow-left')
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
            @break

        @default
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75v.008M12 12v.008M12 17.25v.008" />
            </svg>
    @endswitch
</span>