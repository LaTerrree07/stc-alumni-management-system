<x-app-layout>
    <div class="mx-auto max-w-5xl space-y-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">
                Account Settings
            </h1>

            <p class="mt-1 text-sm text-gray-600">
                Manage your account information, email address, and password.
            </p>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
            <div class="mb-5">
                <h2 class="text-lg font-bold text-gray-900">
                    Account Information
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Update your account name and email address.
                </p>
            </div>

            @include('profile.partials.update-profile-information-form')
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
            <div class="mb-5">
                <h2 class="text-lg font-bold text-gray-900">
                    Update Password
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Use a strong password to keep your account secure.
                </p>
            </div>

            @include('profile.partials.update-password-form')
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-bold text-gray-900">
                Account Access
            </h2>

            <p class="mt-2 text-sm leading-relaxed text-gray-600">
                Account deletion is disabled in this system to protect records and system history.
                If an account needs to be deactivated, please contact the system administrator.
            </p>
        </div>
    </div>
</x-app-layout>