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

    <div class="space-y-6">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    Opportunities
                </h1>

                <p class="mt-1 text-sm text-gray-600">
                    View and manage job opportunities for STCTI alumni.
                </p>
            </div>

            <a
                href="{{ route($routePrefix . '.job-posts.create') }}"
                class="inline-flex items-center justify-center rounded-lg bg-[#6B0F1A] px-4 py-2 text-sm font-semibold text-white hover:bg-[#4A0A12]"
            >
                Add Job Post
            </a>
        </div>

       

        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <form method="GET" action="{{ route($routePrefix . '.job-posts.index') }}" class="space-y-4">
                <input
                    type="text"
                    name="search"
                    value="{{ $search }}"
                    placeholder="Search by company, job title, location, type, or description..."
                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#6B0F1A] focus:ring-[#6B0F1A]"
                >

                <div class="flex flex-col gap-3 sm:flex-row">
                    <select
                        name="status"
                        class="rounded-lg border-gray-300 shadow-sm focus:border-[#6B0F1A] focus:ring-[#6B0F1A]"
                    >
                        <option value="">All Status</option>
                        <option value="pending" @selected($status === 'pending')>Pending</option>
                        <option value="approved" @selected($status === 'approved')>Approved</option>
                        <option value="rejected" @selected($status === 'rejected')>Rejected</option>
                        <option value="archived" @selected($status === 'archived')>Archived</option>
                    </select>

                    <button
                        type="submit"
                        class="rounded-lg bg-[#6B0F1A] px-4 py-2 text-sm font-semibold text-white hover:bg-[#4A0A12]"
                    >
                        Filter
                    </button>

                    @if ($search || $status)
                        <a
                            href="{{ route($routePrefix . '.job-posts.index') }}"
                            class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50 text-center"
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
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Job</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Company</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Submitted By</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse ($jobPosts as $jobPost)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <p class="font-semibold text-gray-900">{{ $jobPost->job_title }}</p>
                                    <p class="text-sm text-gray-500">{{ $jobPost->job_type ?? 'Type not provided' }} · {{ $jobPost->location ?? 'Location not provided' }}</p>
                                </td>

                                <td class="px-6 py-4 text-sm text-gray-700">
                                    {{ $jobPost->company_name }}
                                </td>

                                <td class="px-6 py-4 text-sm text-gray-700">
                                    {{ $jobPost->creator->full_name ?? 'Unknown' }}
                                </td>

                                <td class="px-6 py-4">
                                    <span class="rounded-full border px-3 py-1 text-xs font-semibold {{ $statusClasses[$jobPost->status] ?? 'bg-gray-100 text-gray-700 border-gray-200' }}">
                                        {{ ucfirst($jobPost->status) }}
                                    </span>
                                </td>

                              <td class="px-6 py-4">
    <div class="flex justify-end gap-2">
        <x-action-icon
            :href="route($routePrefix . '.job-posts.show', $jobPost)"
            icon="eye"
            label="View job post"
            variant="view"
        />

        @if (auth()->user()->role === 'admin' || ($jobPost->user_id === auth()->id() && in_array($jobPost->status, ['pending', 'rejected'])))
            <x-action-icon
                :href="route($routePrefix . '.job-posts.edit', $jobPost)"
                icon="pencil"
                label="Edit job post"
                variant="edit"
            />
        @endif

        @if (auth()->user()->role === 'admin')
            @if ($jobPost->status === 'pending')
                <form method="POST" action="{{ route('admin.job-posts.approve', $jobPost) }}">
    @csrf
    @method('PATCH')

    <x-action-icon
        type="button"
        icon="check"
        label="Approve job post"
        variant="approve"
        data-confirm
        data-confirm-title="Approve Job Post"
        data-confirm-message="Are you sure you want to approve this job post? Once approved, it will be visible to alumni."
        data-confirm-text="Approve"
        data-confirm-variant="success"
        data-confirm-icon="success"
    />
</form>
            @endif

            @if (! in_array($jobPost->status, ['rejected', 'archived']))
                <form method="POST" action="{{ route('admin.job-posts.archive', $jobPost) }}">
    @csrf
    @method('PATCH')

    <x-action-icon
        type="button"
        icon="archive"
        label="Archive job post"
        variant="archive"
        data-confirm
        data-confirm-title="Archive Job Post"
        data-confirm-message="Are you sure you want to archive this job post? It will no longer appear as an active opportunity."
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
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <p class="text-sm font-medium text-gray-900">No job posts found.</p>
                                    <p class="mt-1 text-sm text-gray-500">Job opportunities will appear here once created.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($jobPosts->hasPages())
                <div class="border-t border-gray-100 px-6 py-4">
                    {{ $jobPosts->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>