<x-app-layout>
    @php
        $routePrefix = auth()->user()->role === 'admin' ? 'admin' : 'alumni';

        $statusClasses = [
            'pending' => 'bg-amber-50 text-amber-700 border-amber-200',
            'verified' => 'bg-green-50 text-green-700 border-green-200',
            'rejected' => 'bg-red-50 text-red-700 border-red-200',
            'archived' => 'bg-gray-100 text-gray-700 border-gray-200',
        ];
    @endphp

    <div class="mx-auto max-w-5xl space-y-6">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    Donation Details
                </h1>

                <p class="mt-1 text-sm text-gray-600">
                    View donation information, payment details, and verification status.
                </p>
            </div>

            <a
                href="{{ route($routePrefix . '.donations.index') }}"
                class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50"
            >
                Back
            </a>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <h2 class="text-xl font-bold text-gray-900">
                        {{ $donation->donor_name }}
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        {{ $donation->purpose ?? 'Purpose not provided' }}
                    </p>
                </div>

                <span class="w-fit rounded-full border px-3 py-1 text-xs font-semibold {{ $statusClasses[$donation->status] ?? 'bg-gray-100 text-gray-700 border-gray-200' }}">
                    {{ ucfirst($donation->status) }}
                </span>
            </div>

            <div class="mt-6 grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <p class="text-sm font-medium text-gray-500">Amount</p>
                    <p class="mt-1 text-lg font-bold text-gray-900">
                        ₱{{ number_format($donation->amount, 2) }}
                    </p>
                </div>

                <div>
                    <p class="text-sm font-medium text-gray-500">Donation Date</p>
                    <p class="mt-1 text-sm text-gray-900">
                        {{ \App\Support\DateTimeFormatter::dateOnly($donation->donation_date) }}
                    </p>
                </div>

                <div>
                    <p class="text-sm font-medium text-gray-500">Payment Type</p>
                    <p class="mt-1 text-sm capitalize text-gray-900">
                        {{ str_replace('-', ' ', $donation->payment_type) }}
                    </p>
                </div>

                <div>
                    <p class="text-sm font-medium text-gray-500">Payment Method</p>
                    <p class="mt-1 text-sm uppercase text-gray-900">
                        {{ $donation->payment_method }}
                    </p>
                </div>

                <div>
                    <p class="text-sm font-medium text-gray-500">Reference Details</p>
                    <p class="mt-1 text-sm text-gray-900">
                        {{ $donation->reference_details ?? 'Not provided' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm font-medium text-gray-500">Recorded By</p>
                    <p class="mt-1 text-sm text-gray-900">
                        {{ $donation->creator->full_name ?? 'Unknown' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm font-medium text-gray-500">Verified By</p>
                    <p class="mt-1 text-sm text-gray-900">
                        {{ $donation->verifier->full_name ?? 'Not verified yet' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm font-medium text-gray-500">Verified Date</p>
                    <p class="mt-1 text-sm text-gray-900">
                        {{ \App\Support\DateTimeFormatter::dateWithTime($donation->verified_at) }}
                    </p>
                </div>
            </div>

            @if ($donation->proof_of_payment)
                <div class="mt-6">
                    <h3 class="text-lg font-bold text-gray-900">
                        Proof of Payment
                    </h3>

                    <img
                        src="{{ asset('storage/' . $donation->proof_of_payment) }}"
                        alt="Proof of payment"
                        class="mt-3 max-h-[500px] w-full rounded-xl border border-gray-200 bg-gray-50 object-contain"
                    >
                </div>
            @endif

            @if ($donation->admin_note)
                <div class="mt-6 rounded-lg border border-red-200 bg-red-50 p-4">
                    <p class="text-sm font-semibold text-red-700">
                        Admin Note
                    </p>

                    <p class="mt-1 text-sm text-red-700">
                        {{ $donation->admin_note }}
                    </p>
                </div>
            @endif
        </div>

        @if (auth()->user()->role === 'admin' && $donation->status === 'pending')
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-bold text-gray-900">
                    Donation Verification
                </h2>

                <div class="mt-4 flex flex-wrap gap-3">
                    <form method="POST" action="{{ route('admin.donations.verify', $donation) }}">
                        @csrf
                        @method('PATCH')

                        <button
                            type="submit"
                            class="rounded-lg bg-green-600 px-4 py-2 text-sm font-semibold text-white hover:bg-green-700"
                            data-confirm
                            data-confirm-title="Verify Donation"
                            data-confirm-message="Are you sure you want to verify this donation? Once verified, it will be counted in donation totals."
                            data-confirm-text="Verify"
                            data-confirm-variant="success"
                            data-confirm-icon="success"
                        >
                            Verify
                        </button>
                    </form>

                    <form method="POST" action="{{ route('admin.donations.reject', $donation) }}">
                        @csrf
                        @method('PATCH')

                        <button
                            type="submit"
                            class="rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700"
                            data-confirm
                            data-confirm-title="Reject Donation"
                            data-confirm-message="Please provide a reason for rejecting this donation."
                            data-confirm-text="Reject"
                            data-confirm-variant="danger"
                            data-confirm-icon="danger"
                            data-confirm-require-reason="true"
                        >
                            Reject
                        </button>
                    </form>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>