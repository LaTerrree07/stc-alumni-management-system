<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlumniProfile extends Model
{
    protected $primaryKey = 'profile_id';

    protected $fillable = [
        'user_id',
        'profile_picture',
        'contact_number',
        'graduation_year',
        'program',
        'company',
        'location',
        'job_title',
        'skills',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function getCompletionPercentage(): int
{
    $fields = $this->getProfileCompletionFields();

    $completedFields = collect($fields)
        ->filter(fn ($value) => filled($value))
        ->count();

    return (int) round(($completedFields / count($fields)) * 100);
}

public function getMissingFields(): array
{
    $fields = $this->getProfileCompletionFields();

    $labels = [
        'profile_picture' => 'Profile picture',
        'first_name' => 'First name',
        'middle_name' => 'Middle name',
        'last_name' => 'Last name',
        'email' => 'Email',
        'contact_number' => 'Contact number',
        'graduation_year' => 'Graduation year',
        'program' => 'Program',
        'company' => 'Company',
        'job_title' => 'Job title',
        'location' => 'Location',
        'skills' => 'Skills',
    ];

    return collect($fields)
        ->filter(fn ($value) => blank($value))
        ->keys()
        ->map(fn ($field) => $labels[$field])
        ->values()
        ->toArray();
}

private function getProfileCompletionFields(): array
{
    $user = $this->user;

    return [
        'profile_picture' => $this->profile_picture,
        'first_name' => $user?->first_name,
        'middle_name' => $user?->middle_name,
        'last_name' => $user?->last_name,
        'email' => $user?->email,
        'contact_number' => $this->contact_number,
        'graduation_year' => $this->graduation_year,
        'program' => $this->program,
        'company' => $this->company,
        'job_title' => $this->job_title,
        'location' => $this->location,
        'skills' => $this->skills,
    ];
}
}