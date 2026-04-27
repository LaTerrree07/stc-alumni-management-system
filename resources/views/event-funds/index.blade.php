<x-app-layout>
    @php
        $routePrefix = auth()->user()->role === 'admin' ? 'admin' : 'alumni';
    @endphp

    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">
                Event Funds
            </h1>

            <p class="mt-1 text-sm text-gray-600">
                View the yearly event fund, used fund, and remaining fund.
            </p>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <form method="GET" action="{{ route($routePrefix . '.event-funds.index') }}" class="flex flex-col gap-3 sm:flex-row">
                <select
                    name="year"
                    class="rounded-lg border-gray-300 shadow-sm focus:border-[#6B0F1A] focus:ring-[#6B0F1A]"
                >
                    <option value="{{ now()->year }}" @selected($selectedYear == now()->year)>
                        {{ now()->year }}
                    </option>

                    @foreach ($years as $year)
                        <option value="{{ $year }}" @selected($selectedYear == $year)>
                            {{ $year }}
                        </option>
                    @endforeach
                </select>

                <button
                    type="submit"
                    class="rounded-lg bg-[#6B0F1A] px-4 py-2 text-sm font-semibold text-white hover:bg-[#4A0A12]"
                >
                    View Fund
                </button>
            </form>
        </div>

        @if ($eventFund)
            <div class="grid grid-cols-1 gap-5 md:grid-cols-4">
                <x-summary-card
                    title="Available Verified Donations"
                    value="₱{{ number_format($availableVerifiedDonations, 2) }}"
                    variant="primary"
                />

                <x-summary-card
                    title="Total Event Fund"
                    value="₱{{ number_format($eventFund->total_fund, 2) }}"
                    variant="primary"
                />

                <x-summary-card
                    title="Used Fund"
                    value="₱{{ number_format($eventFund->used_fund, 2) }}"
                    variant="warning"
                />

                <x-summary-card
                    title="Remaining Fund"
                    value="₱{{ number_format($eventFund->remaining_fund, 2) }}"
                    variant="success"
                />
            </div>

            @if (auth()->user()->role === 'admin')
                <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                    <h2 class="text-lg font-bold text-gray-900">
                        Update Fund for {{ $eventFund->fund_year }}
                    </h2>

                    <p class="mt-1 text-sm text-gray-600">
                        The total event fund must not exceed the available verified donation balance.
                    </p>

                    <form
                        method="POST"
                        action="{{ route('admin.event-funds.update', $eventFund) }}"
                        class="mt-5 flex flex-col gap-4 sm:flex-row sm:items-end"
                    >
                        @csrf
                        @method('PUT')

                        <div class="flex-1">
                            <x-input-label for="total_fund" :value="__('Total Fund')" />

                            <x-text-input
                                id="total_fund"
                                name="total_fund"
                                type="number"
                                step="0.01"
                                min="{{ $eventFund->used_fund }}"
                                max="{{ $availableVerifiedDonations }}"
                                class="mt-1 block w-full"
                                :value="old('total_fund', $eventFund->total_fund)"
                                required
                            />

                            <p class="mt-1 text-xs text-gray-500">
                                Maximum allowed: ₱{{ number_format($availableVerifiedDonations, 2) }}.
                                Minimum allowed: ₱{{ number_format($eventFund->used_fund, 2) }} because this amount is already used.
                            </p>

                            <x-input-error :messages="$errors->get('total_fund')" class="mt-2" />
                        </div>

                        <button
                            type="submit"
                            class="rounded-lg bg-[#6B0F1A] px-4 py-2 text-sm font-semibold text-white hover:bg-[#4A0A12]"
                            data-confirm
                            data-confirm-title="Update Event Fund"
                            data-confirm-message="Are you sure you want to update this event fund amount?"
                            data-confirm-text="Update"
                            data-confirm-variant="primary"
                            data-confirm-icon="warning"
                        >
                            Update Fund
                        </button>
                    </form>
                </div>
            @endif
        @else
            <div class="rounded-xl border border-gray-200 bg-white p-10 text-center shadow-sm">
                <h2 class="text-base font-semibold text-gray-900">
                    No event fund found for {{ $selectedYear }}.
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    @if (auth()->user()->role === 'admin')
                        Create an event fund record for this year to start tracking used and remaining funds.
                    @else
                        Event fund information for this year is not yet available.
                    @endif
                </p>
            </div>
        @endif

        @if (auth()->user()->role === 'admin')
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-bold text-gray-900">
                    Create Yearly Event Fund
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    The total event fund must not exceed the available verified donation balance.
                </p>

                <form
                    method="POST"
                    action="{{ route('admin.event-funds.store') }}"
                    class="mt-5 grid grid-cols-1 gap-5 md:grid-cols-3"
                >
                    @csrf

                    <div>
                        <x-input-label for="fund_year" :value="__('Fund Year')" />

                        <x-text-input
                            id="fund_year"
                            name="fund_year"
                            type="number"
                            min="2000"
                            max="{{ now()->year + 5 }}"
                            class="mt-1 block w-full"
                            :value="old('fund_year', now()->year)"
                            required
                        />

                        <x-input-error :messages="$errors->get('fund_year')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="new_total_fund" :value="__('Total Fund')" />

                        <x-text-input
                            id="new_total_fund"
                            name="total_fund"
                            type="number"
                            step="0.01"
                            min="0"
                            max="{{ $availableVerifiedDonations }}"
                            class="mt-1 block w-full"
                            :value="old('total_fund')"
                            required
                        />

                        <p class="mt-1 text-xs text-gray-500">
                            Maximum allowed: ₱{{ number_format($availableVerifiedDonations, 2) }} based on verified donations.
                        </p>

                        <x-input-error :messages="$errors->get('total_fund')" class="mt-2" />
                    </div>

                    <div class="flex items-end">
                        <button
                            type="submit"
                            class="w-full rounded-lg bg-[#6B0F1A] px-4 py-2 text-sm font-semibold text-white hover:bg-[#4A0A12]"
                            data-confirm
                            data-confirm-title="Create Event Fund"
                            data-confirm-message="Are you sure you want to create this yearly event fund?"
                            data-confirm-text="Create"
                            data-confirm-variant="primary"
                            data-confirm-icon="neutral"
                        >
                            Create Fund
                        </button>
                    </div>
                </form>
            </div>

            <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                <div class="border-b border-gray-100 px-6 py-4">
                    <h2 class="text-lg font-bold text-gray-900">
                        Event Fund Records
                    </h2>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    Year
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    Total Fund
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    Used Fund
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    Remaining Fund
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse ($eventFunds as $fund)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 text-sm font-semibold text-gray-900">
                                        {{ $fund->fund_year }}
                                    </td>

                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        ₱{{ number_format($fund->total_fund, 2) }}
                                    </td>

                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        ₱{{ number_format($fund->used_fund, 2) }}
                                    </td>

                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        ₱{{ number_format($fund->remaining_fund, 2) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-10 text-center text-sm text-gray-500">
                                        No event fund records yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($eventFunds->hasPages())
                    <div class="border-t border-gray-100 px-6 py-4">
                        {{ $eventFunds->links() }}
                    </div>
                @endif
            </div>
        @endif
    </div>
</x-app-layout>