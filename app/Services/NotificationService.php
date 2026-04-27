<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;

class NotificationService
{
    public function create(
        int $userId,
        string $message,
        ?string $type = null,
        ?string $relatedTable = null,
        ?int $relatedId = null
    ): Notification {
        return Notification::create([
            'user_id' => $userId,
            'message' => $message,
            'type' => $type,
            'status' => 'unread',
            'related_table' => $relatedTable,
            'related_id' => $relatedId,
        ]);
    }

    public function notifyAdmins(
        string $message,
        ?string $type = null,
        ?string $relatedTable = null,
        ?int $relatedId = null
    ): void {
        User::query()
            ->where('role', 'admin')
            ->where('status', 'active')
            ->get()
            ->each(function (User $admin) use ($message, $type, $relatedTable, $relatedId) {
                $this->create(
                    $admin->user_id,
                    $message,
                    $type,
                    $relatedTable,
                    $relatedId
                );
            });
    }

    public function notifyAllAlumni(
        string $message,
        ?string $type = null,
        ?string $relatedTable = null,
        ?int $relatedId = null
    ): void {
        User::query()
            ->where('role', 'alumni')
            ->where('status', 'active')
            ->get()
            ->each(function (User $alumni) use ($message, $type, $relatedTable, $relatedId) {
                $this->create(
                    $alumni->user_id,
                    $message,
                    $type,
                    $relatedTable,
                    $relatedId
                );
            });
    }
}