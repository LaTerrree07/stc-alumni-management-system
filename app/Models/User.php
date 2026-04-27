<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\JobPost;
use App\Models\Event;
use App\Models\EventFund;
use App\Models\Donation;
use App\Models\Announcement;
use App\Models\Notification;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'user_id';

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'password',
        'role',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function alumniProfile()
    {
        return $this->hasOne(AlumniProfile::class, 'user_id', 'user_id');
    }

    public function getFullNameAttribute(): string
{
    return trim($this->first_name . ' ' . ($this->middle_name ? $this->middle_name . ' ' : '') . $this->last_name);
}

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isAlumni(): bool
    {
        return $this->role === 'alumni';
    }

    public function jobPosts()
{
    return $this->hasMany(JobPost::class, 'user_id', 'user_id');
}

public function reviewedJobPosts()
{
    return $this->hasMany(JobPost::class, 'reviewed_by', 'user_id');
}

public function events()
{
    return $this->hasMany(Event::class, 'user_id', 'user_id');
}

public function reviewedEvents()
{
    return $this->hasMany(Event::class, 'reviewed_by', 'user_id');
}

public function eventFunds()
{
    return $this->hasMany(EventFund::class, 'created_by', 'user_id');
}

public function donations()
{
    return $this->hasMany(Donation::class, 'user_id', 'user_id');
}

public function verifiedDonations()
{
    return $this->hasMany(Donation::class, 'verified_by', 'user_id');
}

public function announcements()
{
    return $this->hasMany(Announcement::class, 'user_id', 'user_id');
}

public function notifications()
{
    return $this->hasMany(Notification::class, 'user_id', 'user_id');
}

public function unreadNotifications()
{
    return $this->hasMany(Notification::class, 'user_id', 'user_id')
        ->where('status', 'unread');
}
}