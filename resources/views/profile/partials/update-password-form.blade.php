<section>
    <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <x-input-label for="update_password_current_password" :value="__('Current Password')" />

            <x-password-input
                id="update_password_current_password"
                name="current_password"
                class="mt-1"
                autocomplete="current-password"
            />

            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
            <div>
                <x-input-label for="update_password_password" :value="__('New Password')" />

                <x-password-input
                    id="update_password_password"
                    name="password"
                    class="mt-1"
                    autocomplete="new-password"
                />

                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="update_password_password_confirmation" :value="__('Confirm New Password')" />

                <x-password-input
                    id="update_password_password_confirmation"
                    name="password_confirmation"
                    class="mt-1"
                    autocomplete="new-password"
                />

                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 border-t border-gray-100 pt-5">
            <button
                type="submit"
                class="rounded-lg bg-[#6B0F1A] px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-[#4A0A12] focus:outline-none focus:ring-2 focus:ring-[#6B0F1A] focus:ring-offset-2"
            >
                Update Password
            </button>
        </div>
    </form>
</section>