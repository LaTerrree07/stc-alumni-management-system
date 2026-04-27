<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJobPostRequest;
use App\Http\Requests\UpdateJobPostRequest;
use App\Models\JobPost;
use Illuminate\Http\Request;
use App\Services\NotificationService;

class JobPostController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $query = JobPost::query()
            ->with(['creator', 'reviewer']);

        if (auth()->user()->role === 'alumni') {
            $query->where(function ($jobQuery) {
                $jobQuery
                    ->where('status', 'approved')
                    ->orWhere('user_id', auth()->id());
            });
        }

        $jobPosts = $query
            ->when($search, function ($query, $search) {
                $query->where(function ($jobQuery) use ($search) {
                    $jobQuery
                        ->where('company_name', 'like', "%{$search}%")
                        ->orWhere('job_title', 'like', "%{$search}%")
                        ->orWhere('job_type', 'like', "%{$search}%")
                        ->orWhere('location', 'like', "%{$search}%")
                        ->orWhere('salary_range', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhere('requirements', 'like', "%{$search}%");
                });
            })
            ->when($status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->latest('job_id')
            ->paginate(10)
            ->withQueryString();

        return view('job-posts.index', compact('jobPosts', 'search', 'status'));
    }

    public function create()
    {
        return view('job-posts.create');
    }

    public function store(StoreJobPostRequest $request)
    {
        $status = auth()->user()->role === 'admin' ? 'approved' : 'pending';

      $jobPost = JobPost::create([
    ...$request->validated(),
    'user_id' => auth()->id(),
    'status' => $status,
    'reviewed_by' => auth()->user()->role === 'admin' ? auth()->id() : null,
    'reviewed_at' => auth()->user()->role === 'admin' ? now() : null,
]);

if (auth()->user()->role === 'alumni') {
    app(NotificationService::class)->notifyAdmins(
        auth()->user()->full_name . ' submitted a job post for approval.',
        'job_post',
        'job_posts',
        $jobPost->job_id
    );
}

        return redirect()
            ->route($this->routePrefix() . '.job-posts.index')
            ->with('success', auth()->user()->role === 'admin'
                ? 'Job post created and approved successfully.'
                : 'Job post submitted successfully. It is now pending admin approval.'
            );
    }

    public function show(JobPost $jobPost)
    {
        $this->authorizeView($jobPost);

        $jobPost->load(['creator', 'reviewer']);

        return view('job-posts.show', compact('jobPost'));
    }

    public function edit(JobPost $jobPost)
    {
        $this->authorizeEdit($jobPost);

        return view('job-posts.edit', compact('jobPost'));
    }

    public function update(UpdateJobPostRequest $request, JobPost $jobPost)
    {
        $this->authorizeEdit($jobPost);

        $data = $request->validated();

        if (auth()->user()->role === 'alumni') {
            $data['status'] = 'pending';
            $data['reviewed_by'] = null;
            $data['reviewed_at'] = null;
            $data['admin_note'] = null;
        }

        $jobPost->update($data);

        return redirect()
            ->route($this->routePrefix() . '.job-posts.index')
            ->with('success', auth()->user()->role === 'alumni'
                ? 'Job post updated and resubmitted for approval.'
                : 'Job post updated successfully.'
            );
    }

    public function approve(JobPost $jobPost)
    {
        abort_if(auth()->user()->role !== 'admin', 403);

        $jobPost->update([
            'status' => 'approved',
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
            'admin_note' => null,
        ]);

        app(NotificationService::class)->create(
    $jobPost->user_id,
    'Your job post "' . $jobPost->job_title . '" has been approved.',
    'job_post',
    'job_posts',
    $jobPost->job_id
);

        return redirect()
            ->route('admin.job-posts.index')
            ->with('success', 'Job post approved successfully.');
    }

    public function reject(Request $request, JobPost $jobPost)
    {
        abort_if(auth()->user()->role !== 'admin', 403);

        $validated = $request->validate([
            'admin_note' => ['required', 'string', 'max:1000'],
        ]);

        $jobPost->update([
            'status' => 'rejected',
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
            'admin_note' => $validated['admin_note'],
        ]);

        app(NotificationService::class)->create(
    $jobPost->user_id,
    'Your job post "' . $jobPost->job_title . '" has been rejected. Reason: ' . $validated['admin_note'],
    'job_post',
    'job_posts',
    $jobPost->job_id
);

        return redirect()
            ->route('admin.job-posts.index')
            ->with('success', 'Job post rejected successfully.');
    }

    public function archive(JobPost $jobPost)
    {
        abort_if(auth()->user()->role !== 'admin', 403);

        $jobPost->update([
            'status' => 'archived',
        ]);

        return redirect()
            ->route('admin.job-posts.index')
            ->with('success', 'Job post archived successfully.');
    }

    private function authorizeView(JobPost $jobPost): void
    {
        if (auth()->user()->role === 'admin') {
            return;
        }

        if ($jobPost->status === 'approved' || $jobPost->user_id === auth()->id()) {
            return;
        }

        abort(403);
    }

    private function authorizeEdit(JobPost $jobPost): void
    {
        if (auth()->user()->role === 'admin') {
            return;
        }

        if ($jobPost->user_id === auth()->id() && in_array($jobPost->status, ['pending', 'rejected'])) {
            return;
        }

        abort(403);
    }

    private function routePrefix(): string
    {
        return auth()->user()->role === 'admin' ? 'admin' : 'alumni';
    }
}