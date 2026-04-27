<x-app-layout>
    @php
        $routePrefix = auth()->user()->role === 'admin' ? 'admin' : 'alumni';

        $statusClasses = [
            'pending' => 'bg-amber-50 text-amber-700 border-amber-200',
            'approved' => 'bg-green-50 text-green-700 border-green-200',
            'rejected' => 'bg-red-50 text-red-700 border-red-200',
            'archived' => 'bg-gray-100 text-gray-700 border-gray-200',
        ];
    @endphp

    <div class="mx-auto max-w-5xl space-y-6">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    {{ $jobPost->job_title }}
                </h1>

                <p class="mt-1 text-sm text-gray-600">
                    {{ $jobPost->company_name }}
                </p>
            </div>

            <a
                href="{{ route($routePrefix . '.job-posts.index') }}"
                class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50"
            >
                Back
            </a>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
            <div class="flex flex-wrap gap-2">
                <span class="rounded-full border px-3 py-1 text-xs font-semibold {{ $statusClasses[$jobPost->status] ?? 'bg-gray-100 text-gray-700 border-gray-200' }}">
                    {{ ucfirst($jobPost->status) }}
                </span>

                @if ($jobPost->job_type)
                    <span class="rounded-full border border-gray-200 bg-gray-50 px-3 py-1 text-xs font-semibold text-gray-700">
                        {{ $jobPost->job_type }}
                    </span>
                @endif

                @if ($jobPost->location)
                    <span class="rounded-full border border-gray-200 bg-gray-50 px-3 py-1 text-xs font-semibold text-gray-700">
                        {{ $jobPost->location }}
                    </span>
                @endif
            </div>

            <div class="mt-6 grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <p class="text-sm font-medium text-gray-500">Salary Range</p>
                    <p class="mt-1 text-sm text-gray-900">{{ $jobPost->salary_range ?? 'Not provided' }}</p>
                </div>

                <div>
                    <p class="text-sm font-medium text-gray-500">Submitted By</p>
                    <p class="mt-1 text-sm text-gray-900">{{ $jobPost->creator->full_name ?? 'Unknown' }}</p>
                </div>
            </div>

            <div class="mt-6">
                <h2 class="text-lg font-bold text-gray-900">Job Description</h2>
                <p class="mt-2 whitespace-pre-line text-sm leading-relaxed text-gray-700">{{ $jobPost->description }}</p>
            </div>

            <div class="mt-6">
                <h2 class="text-lg font-bold text-gray-900">Requirements</h2>
                <p class="mt-2 whitespace-pre-line text-sm leading-relaxed text-gray-700">{{ $jobPost->requirements ?? 'Not provided' }}</p>
            </div>

            @if ($jobPost->application_link)
                <div class="mt-6">
                    <a
                        href="{{ $jobPost->application_link }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="inline-flex rounded-lg bg-[#6B0F1A] px-4 py-2 text-sm font-semibold text-white hover:bg-[#4A0A12]"
                    >
                        Open Application Link
                    </a>
                </div>
            @endif

            @if ($jobPost->admin_note)
                <div class="mt-6 rounded-lg border border-red-200 bg-red-50 p-4">
                    <p class="text-sm font-semibold text-red-700">Admin Note</p>
                    <p class="mt-1 text-sm text-red-700">{{ $jobPost->admin_note }}</p>
                </div>
            @endif
        </div>

        @if (auth()->user()->role === 'admin' && $jobPost->status === 'pending')
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-bold text-gray-900">Review Job Post</h2>

                <div class="mt-4 flex flex-col gap-3 sm:flex-row">
                   <form method="POST" action="{{ route('admin.job-posts.approve', $jobPost) }}">
                        @csrf
                        @method('PATCH')

                        <button
    type="submit"
    class="rounded-lg bg-green-600 px-4 py-2 text-sm font-semibold text-white hover:bg-green-700"
    data-confirm
    data-confirm-title="Approve Job Post"
    data-confirm-message="Are you sure you want to approve this job post? Once approved, it will be visible to alumni."
    data-confirm-text="Approve"
    data-confirm-variant="success"
    data-confirm-icon="success"
>
    Approve
</button>
                    </form>

                    <form method="POST" action="{{ route('admin.job-posts.reject', $jobPost) }}">
    @csrf
    @method('PATCH')

    <button
        type="submit"
        class="rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700"
        data-confirm
        data-confirm-title="Reject Job Post"
        data-confirm-message="Please provide a reason for rejecting this job post. The alumni who submitted it should know why it was rejected."
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