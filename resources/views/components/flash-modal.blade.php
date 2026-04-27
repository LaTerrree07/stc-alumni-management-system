@props([
    'id' => 'flashModal',
])

@if (session('success') || session('status') || session('error'))
    @php
        $type = session('error') ? 'error' : 'success';
        $message = session('error') ?? session('success') ?? session('status');
    @endphp

    <div
        id="{{ $id }}"
        class="fixed inset-0 z-[9998] flex items-center justify-center px-4"
        role="dialog"
        aria-modal="true"
        aria-labelledby="{{ $id }}Title"
    >
        <div class="absolute inset-0 bg-gray-900/50"></div>

        <div class="relative w-full max-w-sm rounded-2xl bg-white p-6 text-center shadow-xl">
            @if ($type === 'success')
                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-green-100 text-green-700">
                    <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                    </svg>
                </div>

                <h2 id="{{ $id }}Title" class="mt-4 text-lg font-bold text-gray-900">
                    Success
                </h2>
            @else
                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-red-100 text-red-700">
                    <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a1.5 1.5 0 001.29 2.25h17.78A1.5 1.5 0 0022.18 18L13.71 3.86a1.5 1.5 0 00-2.42 0z" />
                    </svg>
                </div>

                <h2 id="{{ $id }}Title" class="mt-4 text-lg font-bold text-gray-900">
                    Error
                </h2>
            @endif

            <p class="mt-2 text-sm leading-relaxed text-gray-600">
                {{ $message }}
            </p>

            <button
                type="button"
                class="mt-6 w-full rounded-lg bg-[#6B0F1A] px-4 py-2 text-sm font-semibold text-white hover:bg-[#4A0A12] focus:outline-none focus:ring-2 focus:ring-[#6B0F1A] focus:ring-offset-2"
                onclick="document.getElementById('{{ $id }}').remove()"
            >
                OK
            </button>
        </div>
    </div>
@endif