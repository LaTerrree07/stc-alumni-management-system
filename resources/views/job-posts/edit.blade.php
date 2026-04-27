<x-app-layout>
    @php
        $routePrefix = auth()->user()->role === 'admin' ? 'admin' : 'alumni';
    @endphp

    <div class="mx-auto max-w-4xl space-y-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit Job Post</h1>
            <p class="mt-1 text-sm text-gray-600">
                Update job opportunity details.
            </p>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
            <form method="POST" action="{{ route($routePrefix . '.job-posts.update', $jobPost) }}" class="space-y-6">
                @csrf
                @method('PUT')

                @include('job-posts._form', ['jobPost' => $jobPost])

                <div class="flex justify-end gap-3 border-t border-gray-100 pt-5">
                    <a
                        href="{{ route($routePrefix . '.job-posts.index') }}"
                        class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50"
                    >
                        Cancel
                    </a>

                    <button
                        type="submit"
                        class="rounded-lg bg-[#6B0F1A] px-4 py-2 text-sm font-semibold text-white hover:bg-[#4A0A12]"
                    >
                        Update Job Post
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>