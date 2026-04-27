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

    <div class="space-y-6">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    Donations
                </h1>

                <p class="mt-1 text-sm text-gray-600">
                    View, submit, verify, and manage alumni donation records.
                </p>
            </div>

            <a
                href="{{ route($routePrefix . '.donations.create') }}"
                class="inline-flex items-center justify-center rounded-lg bg-[#6B0F1A] px-4 py-2 text-sm font-semibold text-white hover:bg-[#4A0A12]"
            >
                Add Donation
            </a>
        </div>

        <div class="grid grid-cols-1 gap-5 md:grid-cols-3">
            <x-summary-card
                title="Total Verified Donations"
                value="₱{{ number_format($totalVerifiedDonations, 2) }}"
                variant="success"
            />

            <x-summary-card
                title="Pending Donations"
                value="{{ $pendingDonations }}"
                variant="warning"
            />

            <x-summary-card
                title="Verified Records"
                value="{{ $verifiedDonations }}"
                variant="primary"
            />
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <form method="GET" action="{{ route($routePrefix . '.donations.index') }}" class="space-y-4">
                <input
                    type="text"
                    name="search"
                    value="{{ $search }}"
                    placeholder="Search by donor, reference, payment method, or purpose..."
                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#6B0F1A] focus:ring-[#6B0F1A]"
                >

                <div class="flex flex-col gap-3 sm:flex-row">
                    <select
                        name="status"
                        class="rounded-lg border-gray-300 shadow-sm focus:border-[#6B0F1A] focus:ring-[#6B0F1A]"
                    >
                        <option value="">All Status</option>
                        <option value="pending" @selected($status === 'pending')>Pending</option>
                        <option value="verified" @selected($status === 'verified')>Verified</option>
                        <option value="rejected" @selected($status === 'rejected')>Rejected</option>
                        <option value="archived" @selected($status === 'archived')>Archived</option>
                    </select>

                    <select
                        name="payment_type"
                        class="rounded-lg border-gray-300 shadow-sm focus:border-[#6B0F1A] focus:ring-[#6B0F1A]"
                    >
                        <option value="">All Payment Types</option>
                        <option value="e-wallet" @selected($paymentType === 'e-wallet')>E-wallet</option>
                        <option value="bank" @selected($paymentType === 'bank')>Bank</option>
                    </select>

                    <button
                        type="submit"
                        class="rounded-lg bg-[#6B0F1A] px-4 py-2 text-sm font-semibold text-white hover:bg-[#4A0A12]"
                    >
                        Filter
                    </button>

                    @if ($search || $status || $paymentType)
                        <a
                            href="{{ route($routePrefix . '.donations.index') }}"
                            class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-center text-sm font-semibold text-gray-700 hover:bg-gray-50"
                        >
                            Clear
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Donor</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Payment</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse ($donations as $donation)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <p class="font-semibold text-gray-900">{{ $donation->donor_name }}</p>
                                    <p class="text-sm text-gray-500">{{ $donation->purpose ?? 'Purpose not provided' }}</p>
                                </td>

                                <td class="px-6 py-4 text-sm font-semibold text-gray-900">
                                    ₱{{ number_format($donation->amount, 2) }}
                                </td>

                                <td class="px-6 py-4 text-sm text-gray-700">
                                    <p class="capitalize">{{ str_replace('-', ' ', $donation->payment_type) }}</p>
                                    <p class="text-xs uppercase text-gray-500">{{ $donation->payment_method }}</p>
                                </td>

                                <td class="px-6 py-4 text-sm text-gray-700">
                                    {{ \App\Support\DateTimeFormatter::dateOnly($donation->donation_date) }}
                                </td>

                                <td class="px-6 py-4">
                                    <span class="rounded-full border px-3 py-1 text-xs font-semibold {{ $statusClasses[$donation->status] ?? 'bg-gray-100 text-gray-700 border-gray-200' }}">
                                        {{ ucfirst($donation->status) }}
                                    </span>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex justify-end gap-2">
                                        <x-action-icon
                                            :href="route($routePrefix . '.donations.show', $donation)"
                                            icon="eye"
                                            label="View donation"
                                            variant="view"
                                        />

                                        @if (auth()->user()->role === 'admin' || ($donation->user_id === auth()->id() && in_array($donation->status, ['pending', 'rejected'])))
                                            <x-action-icon
                                                :href="route($routePrefix . '.donations.edit', $donation)"
                                                icon="pencil"
                                                label="Edit donation"
                                                variant="edit"
                                            />
                                        @endif

                                        @if (auth()->user()->role === 'admin')
                                            @if ($donation->status === 'pending')
                                                <form method="POST" action="{{ route('admin.donations.verify', $donation) }}">
                                                    @csrf
                                                    @method('PATCH')

                                                    <x-action-icon
                                                        type="button"
                                                        icon="shield-check"
                                                        label="Verify donation"
                                                        variant="verify"
                                                        data-confirm
                                                        data-confirm-title="Verify Donation"
                                                        data-confirm-message="Are you sure you want to verify this donation? Once verified, it will be counted in donation totals."
                                                        data-confirm-text="Verify"
                                                        data-confirm-variant="success"
                                                        data-confirm-icon="success"
                                                    />
                                                </form>

                                                <form method="POST" action="{{ route('admin.donations.reject', $donation) }}">
                                                    @csrf
                                                    @method('PATCH')

                                                    <x-action-icon
                                                        type="button"
                                                        icon="x"
                                                        label="Reject donation"
                                                        variant="reject"
                                                        data-confirm
                                                        data-confirm-title="Reject Donation"
                                                        data-confirm-message="Please provide a reason for rejecting this donation."
                                                        data-confirm-text="Reject"
                                                        data-confirm-variant="danger"
                                                        data-confirm-icon="danger"
                                                        data-confirm-require-reason="true"
                                                    />
                                                </form>
                                            @endif

                                            @if (! in_array($donation->status, ['archived']))
                                                <form method="POST" action="{{ route('admin.donations.archive', $donation) }}">
                                                    @csrf
                                                    @method('PATCH')

                                                    <x-action-icon
                                                        type="button"
                                                        icon="archive"
                                                        label="Archive donation"
                                                        variant="archive"
                                                        data-confirm
                                                        data-confirm-title="Archive Donation"
                                                        data-confirm-message="Are you sure you want to archive this donation record?"
                                                        data-confirm-text="Archive"
                                                        data-confirm-variant="neutral"
                                                        data-confirm-icon="warning"
                                                    />
                                                </form>
                                            @endif
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <p class="text-sm font-medium text-gray-900">No donations found.</p>
                                    <p class="mt-1 text-sm text-gray-500">Donation records will appear here once created.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($donations->hasPages())
                <div class="border-t border-gray-100 px-6 py-4">
                    {{ $donations->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>