<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDonationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'donor_name' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:1'],
            'donation_date' => ['required', 'date'],
            'payment_type' => ['required', Rule::in(['e-wallet', 'bank'])],
            'payment_method' => ['required', Rule::in(['gcash', 'bpi', 'landbank'])],
            'reference_details' => ['nullable', 'string', 'max:255'],
            'proof_of_payment' => [
                auth()->user()->role === 'alumni' ? 'required' : 'nullable',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048',
            ],
            'purpose' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            if ($this->payment_type === 'e-wallet' && $this->payment_method !== 'gcash') {
                $validator->errors()->add('payment_method', 'GCash is the only allowed method for E-wallet payments.');
            }

            if ($this->payment_type === 'bank' && ! in_array($this->payment_method, ['bpi', 'landbank'])) {
                $validator->errors()->add('payment_method', 'BPI and Landbank are the only allowed methods for Bank payments.');
            }
        });
    }
}