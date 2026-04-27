<div class="grid grid-cols-1 gap-5 md:grid-cols-2">
    <div>
        <x-input-label for="donor_name" :value="__('Donor Name')" />
        <x-text-input
            id="donor_name"
            name="donor_name"
            type="text"
            class="mt-1 block w-full"
            :value="old('donor_name', $donation->donor_name ?? auth()->user()->full_name)"
            required
        />
        <x-input-error :messages="$errors->get('donor_name')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="amount" :value="__('Amount')" />
        <x-text-input
            id="amount"
            name="amount"
            type="number"
            step="0.01"
            min="1"
            class="mt-1 block w-full"
            :value="old('amount', $donation->amount ?? '')"
            required
        />
        <x-input-error :messages="$errors->get('amount')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="donation_date" :value="__('Donation Date')" />
        <x-text-input
            id="donation_date"
            name="donation_date"
            type="date"
            class="mt-1 block w-full"
            :value="old('donation_date', isset($donation) ? $donation->donation_date?->format('Y-m-d') : now()->format('Y-m-d'))"
            required
        />
        <x-input-error :messages="$errors->get('donation_date')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="purpose" :value="__('Purpose')" />
        <x-text-input
            id="purpose"
            name="purpose"
            type="text"
            class="mt-1 block w-full"
            :value="old('purpose', $donation->purpose ?? '')"
            placeholder="Example: Alumni event support"
        />
        <x-input-error :messages="$errors->get('purpose')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="payment_type" :value="__('Payment Type')" />
        <select
            id="payment_type"
            name="payment_type"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#6B0F1A] focus:ring-[#6B0F1A]"
            required
        >
            <option value="">Select payment type</option>
            <option value="e-wallet" @selected(old('payment_type', $donation->payment_type ?? '') === 'e-wallet')>
                E-wallet
            </option>
            <option value="bank" @selected(old('payment_type', $donation->payment_type ?? '') === 'bank')>
                Bank
            </option>
        </select>
        <x-input-error :messages="$errors->get('payment_type')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="payment_method" :value="__('Payment Method')" />
        <select
            id="payment_method"
            name="payment_method"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#6B0F1A] focus:ring-[#6B0F1A]"
            required
        >
            <option value="">Select payment method</option>
            <option value="gcash" @selected(old('payment_method', $donation->payment_method ?? '') === 'gcash')>
                GCash
            </option>
            <option value="bpi" @selected(old('payment_method', $donation->payment_method ?? '') === 'bpi')>
                BPI
            </option>
            <option value="landbank" @selected(old('payment_method', $donation->payment_method ?? '') === 'landbank')>
                Landbank
            </option>
        </select>
        <p class="mt-1 text-xs text-gray-500">
            E-wallet allows GCash only. Bank allows BPI or Landbank only.
        </p>
        <x-input-error :messages="$errors->get('payment_method')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="reference_details" :value="__('Reference Details')" />
        <x-text-input
            id="reference_details"
            name="reference_details"
            type="text"
            class="mt-1 block w-full"
            :value="old('reference_details', $donation->reference_details ?? '')"
            placeholder="Reference number or transaction details"
        />
        <x-input-error :messages="$errors->get('reference_details')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="proof_of_payment" :value="__('Proof of Payment')" />
        <input
            id="proof_of_payment"
            name="proof_of_payment"
            type="file"
            accept="image/png,image/jpeg,image/jpg"
            class="mt-1 block w-full text-sm text-gray-700 file:mr-4 file:rounded-lg file:border-0 file:bg-[#6B0F1A] file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-[#4A0A12]"
        />
        <p class="mt-1 text-xs text-gray-500">
            Accepted formats: JPG, JPEG, PNG. Max size: 2MB.
        </p>
        <x-input-error :messages="$errors->get('proof_of_payment')" class="mt-2" />
    </div>
</div>

@if (isset($donation) && $donation->proof_of_payment)
    <div>
        <p class="mb-2 text-sm font-medium text-gray-700">
            Current Proof of Payment
        </p>

        <img
            src="{{ asset('storage/' . $donation->proof_of_payment) }}"
            alt="Proof of payment"
            class="h-56 w-full rounded-xl border border-gray-200 object-contain bg-gray-50"
        >
    </div>
@endif