@props([
    'id',
    'name',
    'value' => null,
])

<div class="relative">
    <input
        id="{{ $id }}"
        name="{{ $name }}"
        type="password"
        value="{{ $value }}"
        {{ $attributes->merge([
            'class' => 'block w-full rounded-md border-gray-300 pr-12 shadow-sm focus:border-[#6B0F1A] focus:ring-[#6B0F1A]',
        ]) }}
    >

    <button
        type="button"
        class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 transition hover:text-[#6B0F1A] focus:outline-none focus:ring-2 focus:ring-[#6B0F1A] focus:ring-offset-2"
        data-password-toggle
        data-password-target="{{ $id }}"
        aria-label="Show password"
    >
        <svg
            class="h-5 w-5 password-eye"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            viewBox="0 0 24 24"
        >
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12s-3.75 6.75-9.75 6.75S2.25 12 2.25 12z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>

        <svg
            class="hidden h-5 w-5 password-eye-off"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            viewBox="0 0 24 24"
        >
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.58 10.58A2 2 0 0012 14a2 2 0 001.42-3.42" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M9.88 5.55A9.4 9.4 0 0112 5.25c6 0 9.75 6.75 9.75 6.75a17.72 17.72 0 01-3.13 3.96" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M6.11 6.11C3.65 7.82 2.25 12 2.25 12s3.75 6.75 9.75 6.75a9.7 9.7 0 004.03-.86" />
        </svg>
    </button>
</div>