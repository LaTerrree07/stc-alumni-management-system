<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status');

        $notifications = Notification::query()
            ->where('user_id', auth()->id())
            ->when($status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->latest('notification_id')
            ->paginate(10)
            ->withQueryString();

        $unreadCount = Notification::query()
            ->where('user_id', auth()->id())
            ->where('status', 'unread')
            ->count();

        $readCount = Notification::query()
            ->where('user_id', auth()->id())
            ->where('status', 'read')
            ->count();

        return view('notifications.index', compact(
            'notifications',
            'status',
            'unreadCount',
            'readCount'
        ));
    }

    public function markAsRead(Notification $notification)
    {
        abort_if($notification->user_id !== auth()->id(), 403);

        $notification->update([
            'status' => 'read',
        ]);

        return redirect()
            ->route($this->routePrefix() . '.notifications.index')
            ->with('success', 'Notification marked as read.');
    }

    public function markAllAsRead()
    {
        Notification::query()
            ->where('user_id', auth()->id())
            ->where('status', 'unread')
            ->update([
                'status' => 'read',
            ]);

        return redirect()
            ->route($this->routePrefix() . '.notifications.index')
            ->with('success', 'All notifications marked as read.');
    }

    private function routePrefix(): string
    {
        return auth()->user()->role === 'admin' ? 'admin' : 'alumni';
    }
}