<section>
    <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('PATCH')

        <div class="grid grid-cols-1 gap-5 md:grid-cols-3">
            <div>
                <x-input-label for="first_name" :value="__('First Name')" />

                <x-text-input
                    id="first_name"
                    name="first_name"
                    type="text"
                    class="mt-1 block w-full"
                    :value="old('first_name', $user->first_name)"
                    required
                    autofocus
                    autocomplete="given-name"
                />

                <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
            </div>

            <div>
                <x-input-label for="middle_name" :value="__('Middle Name')" />

                <x-text-input
                    id="middle_name"
                    name="middle_name"
                    type="text"
                    class="mt-1 block w-full"
                    :value="old('middle_name', $user->middle_name)"
                    autocomplete="additional-name"
                />

                <x-input-error class="mt-2" :messages="$errors->get('middle_name')" />
            </div>

            <div>
                <x-input-label for="last_name" :value="__('Last Name')" />

                <x-text-input
                    id="last_name"
                    name="last_name"
                    type="text"
                    class="mt-1 block w-full"
                    :value="old('last_name', $user->last_name)"
                    required
                    autocomplete="family-name"
                />

                <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
            </div>
        </div>

       <div>
    <x-input-label for="email" :value="__('Email Address')" />

    <div class="mt-1 flex items-center justify-between rounded-lg border border-gray-300 bg-gray-50 px-3 py-2">
        <span class="text-sm text-gray-700">
            {{ $user->email }}
        </span>

        <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-600">
            Cannot be changed
        </span>
    </div>

    <p class="mt-1 text-xs text-gray-500">
        Email address changes are restricted for account security. Please contact the system administrator if this needs to be updated.
    </p>
</div>

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div class="rounded-lg border border-amber-200 bg-amber-50 p-4">
                <p class="text-sm text-amber-700">
                    Your email address is unverified.

                    <button
                        form="send-verification"
                        class="rounded-md text-sm font-medium text-[#6B0F1A] underline hover:text-[#4A0A12]"
                    >
                        Click here to re-send the verification email.
                    </button>
                </p>

                @if (session('status') === 'verification-link-sent')
                    <p class="mt-2 text-sm font-medium text-green-700">
                        A new verification link has been sent to your email address.
                    </p>
                @endif
            </div>
        @endif

        <div class="flex items-center justify-end gap-3 border-t border-gray-100 pt-5">
            <a
                href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('alumni.dashboard') }}"
                class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50"
            >
                Cancel
            </a>

            <button
                type="submit"
                class="rounded-lg bg-[#6B0F1A] px-4 py-2 text-sm font-semibold text-white hover:bg-[#4A0A12] focus:outline-none focus:ring-2 focus:ring-[#6B0F1A] focus:ring-offset-2"
            >
                Save Changes
            </button>
        </div>
    </form>

    <form id="send-verification" method="POST" action="{{ route('verification.send') }}">
        @csrf
    </form>
</section>