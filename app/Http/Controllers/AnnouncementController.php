<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnnouncementRequest;
use App\Http\Requests\UpdateAnnouncementRequest;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Services\NotificationService;

class AnnouncementController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $query = Announcement::query()
            ->with('creator');

        if (auth()->user()->role === 'alumni') {
            $query->where('status', 'published');
        }

        $announcements = $query
            ->when($search, function ($query, $search) {
                $query->where(function ($announcementQuery) use ($search) {
                    $announcementQuery
                        ->where('title', 'like', "%{$search}%")
                        ->orWhere('content', 'like', "%{$search}%");
                });
            })
            ->when($status && auth()->user()->role === 'admin', function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->latest('announcement_id')
            ->paginate(10)
            ->withQueryString();

        $publishedCount = Announcement::where('status', 'published')->count();
        $draftCount = Announcement::where('status', 'draft')->count();
        $archivedCount = Announcement::where('status', 'archived')->count();

        return view('announcements.index', compact(
            'announcements',
            'search',
            'status',
            'publishedCount',
            'draftCount',
            'archivedCount'
        ));
    }

    public function create()
    {
        abort_if(auth()->user()->role !== 'admin', 403);

        return view('announcements.create');
    }

    public function store(StoreAnnouncementRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')
                ->store('announcement-images', 'public');
        }

      $announcement = Announcement::create([
    ...$validated,
    'user_id' => auth()->id(),
    'published_at' => $validated['status'] === 'published' ? now() : null,
]);

if ($announcement->status === 'published') {
    app(NotificationService::class)->notifyAllAlumni(
        'New announcement posted: ' . $announcement->title,
        'announcement',
        'announcements',
        $announcement->announcement_id
    );
}

        return redirect()
            ->route('admin.announcements.index')
            ->with('success', $validated['status'] === 'published'
                ? 'Announcement published successfully.'
                : 'Announcement saved as draft successfully.'
            );
    }

    public function show(Announcement $announcement)
    {
        $this->authorizeView($announcement);

        $announcement->load('creator');

        return view('announcements.show', compact('announcement'));
    }

    public function edit(Announcement $announcement)
    {
        abort_if(auth()->user()->role !== 'admin', 403);

        return view('announcements.edit', compact('announcement'));
    }

    public function update(UpdateAnnouncementRequest $request, Announcement $announcement)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($announcement->image) {
                Storage::disk('public')->delete($announcement->image);
            }

            $validated['image'] = $request->file('image')
                ->store('announcement-images', 'public');
        }

        if ($announcement->status !== 'published' && $validated['status'] === 'published') {
            $validated['published_at'] = now();
        }

        if ($validated['status'] === 'draft') {
            $validated['published_at'] = null;
        }

       $wasPublished = $announcement->status === 'published';

$announcement->update($validated);

if (! $wasPublished && $announcement->status === 'published') {
    app(NotificationService::class)->notifyAllAlumni(
        'New announcement posted: ' . $announcement->title,
        'announcement',
        'announcements',
        $announcement->announcement_id
    );
}

        return redirect()
            ->route('admin.announcements.index')
            ->with('success', 'Announcement updated successfully.');
    }

    public function publish(Announcement $announcement)
    {
        abort_if(auth()->user()->role !== 'admin', 403);

        $announcement->update([
            'status' => 'published',
            'published_at' => now(),
        ]);

        app(NotificationService::class)->notifyAllAlumni(
    'New announcement posted: ' . $announcement->title,
    'announcement',
    'announcements',
    $announcement->announcement_id
);

        return redirect()
            ->route('admin.announcements.index')
            ->with('success', 'Announcement published successfully.');
    }

    public function archive(Announcement $announcement)
    {
        abort_if(auth()->user()->role !== 'admin', 403);

        $announcement->update([
            'status' => 'archived',
        ]);

        return redirect()
            ->route('admin.announcements.index')
            ->with('success', 'Announcement archived successfully.');
    }

    private function authorizeView(Announcement $announcement): void
    {
        if (auth()->user()->role === 'admin') {
            return;
        }

        if ($announcement->status === 'published') {
            return;
        }

        abort(403);
    }
}