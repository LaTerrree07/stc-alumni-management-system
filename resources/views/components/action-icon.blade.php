@props([
    'href' => null,
    'type' => 'link',
    'icon' => 'eye',
    'label' => 'Action',
    'variant' => 'neutral',
])

@php
    $baseClasses = 'inline-flex h-9 w-9 items-center justify-center rounded-lg border text-sm font-semibold transition focus:outline-none focus:ring-2 focus:ring-offset-2';

    $variantClasses = [
        'view' => 'border-blue-200 bg-blue-50 text-blue-700 hover:bg-blue-100 focus:ring-blue-500',
        'edit' => 'border-amber-200 bg-amber-50 text-amber-700 hover:bg-amber-100 focus:ring-amber-500',
        'approve' => 'border-green-200 bg-green-50 text-green-700 hover:bg-green-100 focus:ring-green-500',
        'verify' => 'border-green-200 bg-green-50 text-green-700 hover:bg-green-100 focus:ring-green-500',
        'reject' => 'border-red-200 bg-red-50 text-red-700 hover:bg-red-100 focus:ring-red-500',
        'delete' => 'border-red-200 bg-red-50 text-red-700 hover:bg-red-100 focus:ring-red-500',
        'archive' => 'border-gray-200 bg-gray-50 text-gray-700 hover:bg-gray-100 focus:ring-gray-500',
        'restore' => 'border-indigo-200 bg-indigo-50 text-indigo-700 hover:bg-indigo-100 focus:ring-indigo-500',
        'publish' => 'border-[#6B0F1A]/20 bg-[#6B0F1A]/10 text-[#6B0F1A] hover:bg-[#6B0F1A]/15 focus:ring-[#6B0F1A]',
        'neutral' => 'border-gray-200 bg-white text-gray-700 hover:bg-gray-50 focus:ring-gray-500',
    ];

    $classes = $baseClasses . ' ' . ($variantClasses[$variant] ?? $variantClasses['neutral']);
@endphp

@if ($type === 'button')
    <button
        type="submit"
        {{ $attributes->merge(['class' => $classes]) }}
        title="{{ $label }}"
        aria-label="{{ $label }}"
    >
        @include('components.partials.action-icon-svg', ['icon' => $icon])
    </button>
@else
    <a
        href="{{ $href }}"
        {{ $attributes->merge(['class' => $classes]) }}
        title="{{ $label }}"
        aria-label="{{ $label }}"
    >
        @include('components.partials.action-icon-svg', ['icon' => $icon])
    </a>
@endif