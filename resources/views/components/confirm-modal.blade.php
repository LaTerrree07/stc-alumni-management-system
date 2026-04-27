@props([
    'id' => 'confirmModal',
    'title' => 'Confirm Action',
    'message' => 'Are you sure you want to continue?',
    'confirmText' => 'Confirm',
    'cancelText' => 'Cancel',
    'variant' => 'primary',
])

@php
    $variantClasses = [
        'primary' => 'bg-[#6B0F1A] hover:bg-[#4A0A12] focus:ring-[#6B0F1A]',
        'success' => 'bg-green-600 hover:bg-green-700 focus:ring-green-600',
        'warning' => 'bg-amber-600 hover:bg-amber-700 focus:ring-amber-600',
        'danger' => 'bg-red-600 hover:bg-red-700 focus:ring-red-600',
        'neutral' => 'bg-gray-700 hover:bg-gray-800 focus:ring-gray-700',
    ];

    $buttonClass = $variantClasses[$variant] ?? $variantClasses['primary'];
@endphp

<div
    id="{{ $id }}"
    class="fixed inset-0 z-[9999] hidden items-center justify-center px-4"
    aria-labelledby="{{ $id }}Title"
    role="dialog"
    aria-modal="true"
>
    <!-- Overlay -->
    <div
        class="absolute inset-0 bg-gray-900/50"
        data-modal-close="{{ $id }}"
    ></div>

    <!-- Modal Box -->
    <div class="relative w-full max-w-md rounded-2xl bg-white p-6 shadow-xl">
        <div class="flex items-start gap-4">
            <div
                id="{{ $id }}Icon"
                class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full"
            >
                <!-- Icon inserted by JavaScript -->
            </div>

            <div class="flex-1">
                <h2
                    id="{{ $id }}Title"
                    class="text-lg font-bold text-gray-900"
                >
                    {{ $title }}
                </h2>

                <p
                    id="{{ $id }}Message"
                    class="mt-2 text-sm leading-relaxed text-gray-600"
                >
                    {{ $message }}
                </p>
            </div>
        </div>

        <div id="{{ $id }}ExtraContent" class="mt-5 hidden">
            <!-- Extra content inserted by JavaScript if needed -->
        </div>

        <div class="mt-6 flex justify-end gap-3">
            <button
                type="button"
                class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2"
                data-modal-close="{{ $id }}"
            >
                {{ $cancelText }}
            </button>

            <button
                type="button"
                id="{{ $id }}ConfirmButton"
                class="rounded-lg px-4 py-2 text-sm font-semibold text-white focus:outline-none focus:ring-2 focus:ring-offset-2 {{ $buttonClass }}"
            >
                {{ $confirmText }}
            </button>
        </div>
    </div>
</div>