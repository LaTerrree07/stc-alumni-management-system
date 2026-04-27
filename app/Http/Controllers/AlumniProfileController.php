<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AlumniProfileController extends Controller
{
    public function edit()
{
    $user = auth()->user();

    $profile = $user->alumniProfile()->firstOrCreate([
        'user_id' => $user->user_id,
    ]);

    $profile->load('user');

    $completionPercentage = $profile->getCompletionPercentage();
    $missingFields = $profile->getMissingFields();

    return view('alumni.profile.edit', compact(
        'profile',
        'completionPercentage',
        'missingFields'
    ));
}

    public function update(Request $request)
    {
        $validated = $request->validate([
            'profile_picture' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'contact_number' => ['nullable', 'string', 'max:20'],
            'graduation_year' => ['nullable', 'integer', 'min:1900', 'max:' . now()->year],
            'program' => ['nullable', 'string', 'max:255'],
            'company' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'job_title' => ['nullable', 'string', 'max:255'],
            'skills' => ['nullable', 'string', 'max:1000'],
        ]);

        $profile = auth()->user()->alumniProfile;

        if ($request->hasFile('profile_picture')) {
            if ($profile && $profile->profile_picture) {
                Storage::disk('public')->delete($profile->profile_picture);
            }

            $validated['profile_picture'] = $request->file('profile_picture')
                ->store('profile-pictures', 'public');
        }

        auth()->user()->alumniProfile()->updateOrCreate(
            ['user_id' => auth()->id()],
            $validated
        );

        return redirect()
            ->route('alumni.profile.edit')
            ->with('success', 'Profile updated successfully.');
    }
}