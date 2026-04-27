<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Donation;
use App\Models\Event;
use App\Models\JobPost;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function redirect()
    {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('alumni.dashboard');
    }

    public function admin()
    {
        $summary = [
            'totalAlumni' => User::where('role', 'alumni')->count(),
            'totalJobPosts' => JobPost::count(),
            'pendingJobPosts' => JobPost::where('status', 'pending')->count(),
            'approvedJobPosts' => JobPost::where('status', 'approved')->count(),
            'totalEvents' => Event::count(),
            'pendingEvents' => Event::where('status', 'pending')->count(),
            'approvedEvents' => Event::where('status', 'approved')->count(),
            'totalVerifiedDonations' => Donation::where('status', 'verified')->sum('amount'),
            'pendingDonations' => Donation::where('status', 'pending')->count(),
            'totalAnnouncements' => Announcement::count(),
            'publishedAnnouncements' => Announcement::where('status', 'published')->count(),
            'unreadNotifications' => Notification::where('user_id', auth()->id())
                ->where('status', 'unread')
                ->count(),
        ];

        $charts = [
            'alumniByGraduationYear' => $this->alumniByGraduationYear(),
            'jobPostsByStatus' => $this->countByStatus(JobPost::class),
            'eventsByStatus' => $this->countByStatus(Event::class),
            'donationsByMonth' => $this->donationsByMonth(),
            'donationsByPaymentMethod' => $this->donationsByPaymentMethod(),
            'announcementsByStatus' => $this->countByStatus(Announcement::class),
        ];

        $recent = [
            'alumni' => User::with('alumniProfile')
                ->where('role', 'alumni')
                ->latest('user_id')
                ->take(5)
                ->get(),

            'jobPosts' => JobPost::with('creator')
                ->latest('job_id')
                ->take(5)
                ->get(),

            'events' => Event::with('creator')
                ->latest('event_id')
                ->take(5)
                ->get(),

            'donations' => Donation::with('creator')
                ->latest('donation_id')
                ->take(5)
                ->get(),

            'announcements' => Announcement::with('creator')
                ->latest('announcement_id')
                ->take(5)
                ->get(),

            'notifications' => Notification::where('user_id', auth()->id())
                ->latest('notification_id')
                ->take(5)
                ->get(),
        ];

        return view('admin.dashboard', compact('summary', 'charts', 'recent'));
    }

    public function alumni()
    {
        $summary = [
            'mySubmittedJobPosts' => JobPost::where('user_id', auth()->id())->count(),
            'myPendingJobPosts' => JobPost::where('user_id', auth()->id())
                ->where('status', 'pending')
                ->count(),
            'availableApprovedJobPosts' => JobPost::where('status', 'approved')->count(),

            'upcomingApprovedEvents' => Event::where('status', 'approved')
                ->whereDate('event_date', '>=', now()->toDateString())
                ->count(),
            'mySubmittedEvents' => Event::where('user_id', auth()->id())->count(),

            'myDonations' => Donation::where('user_id', auth()->id())->count(),
            'myPendingDonations' => Donation::where('user_id', auth()->id())
                ->where('status', 'pending')
                ->count(),
            'myVerifiedDonations' => Donation::where('user_id', auth()->id())
                ->where('status', 'verified')
                ->sum('amount'),

            'publishedAnnouncements' => Announcement::where('status', 'published')->count(),
            'unreadNotifications' => Notification::where('user_id', auth()->id())
                ->where('status', 'unread')
                ->count(),
        ];

        $charts = [
            'myJobPostsByStatus' => $this->countByStatus(JobPost::class, auth()->id()),
            'myEventsByStatus' => $this->countByStatus(Event::class, auth()->id()),
            'myDonationsByStatus' => $this->countByStatus(Donation::class, auth()->id()),
            'myDonationsByMonth' => $this->donationsByMonth(auth()->id()),
            'availableEventsByMonth' => $this->eventsByMonth(),
        ];

        $recent = [
            'jobPosts' => JobPost::where('status', 'approved')
                ->latest('job_id')
                ->take(5)
                ->get(),

            'events' => Event::where('status', 'approved')
                ->whereDate('event_date', '>=', now()->toDateString())
                ->orderBy('event_date')
                ->take(5)
                ->get(),

            'donations' => Donation::where('user_id', auth()->id())
                ->latest('donation_id')
                ->take(5)
                ->get(),

            'announcements' => Announcement::where('status', 'published')
                ->latest('announcement_id')
                ->take(5)
                ->get(),

            'notifications' => Notification::where('user_id', auth()->id())
                ->latest('notification_id')
                ->take(5)
                ->get(),
        ];

        return view('alumni.dashboard', compact('summary', 'charts', 'recent'));
    }

    private function countByStatus(string $modelClass, ?int $userId = null): array
    {
        $query = $modelClass::query()
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status');

        if ($userId) {
            $query->where('user_id', $userId);
        }

        return $query->pluck('total', 'status')->toArray();
    }

    private function alumniByGraduationYear(): array
    {
        return DB::table('alumni_profiles')
            ->select('graduation_year', DB::raw('COUNT(*) as total'))
            ->whereNotNull('graduation_year')
            ->groupBy('graduation_year')
            ->orderBy('graduation_year')
            ->pluck('total', 'graduation_year')
            ->toArray();
    }

    private function donationsByMonth(?int $userId = null): array
    {
        $query = Donation::query()
            ->selectRaw('MONTH(donation_date) as month, SUM(amount) as total')
            ->where('status', 'verified')
            ->whereYear('donation_date', now()->year)
            ->groupBy('month')
            ->orderBy('month');

        if ($userId) {
            $query->where('user_id', $userId);
        }

        return $query->pluck('total', 'month')->toArray();
    }

    private function donationsByPaymentMethod(): array
    {
        return Donation::query()
            ->select('payment_method', DB::raw('COUNT(*) as total'))
            ->where('status', 'verified')
            ->groupBy('payment_method')
            ->pluck('total', 'payment_method')
            ->toArray();
    }

    private function eventsByMonth(): array
    {
        return Event::query()
            ->selectRaw('MONTH(event_date) as month, COUNT(*) as total')
            ->where('status', 'approved')
            ->whereYear('event_date', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();
    }
}