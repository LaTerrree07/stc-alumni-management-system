<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AlumniProfileController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $alumni = User::query()
            ->with('alumniProfile')
            ->where('role', 'alumni')
            ->when($search, function ($query, $search) {
                $query->where(function ($userQuery) use ($search) {
                    $userQuery
                        ->where('first_name', 'like', "%{$search}%")
                        ->orWhere('middle_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhereHas('alumniProfile', function ($profileQuery) use ($search) {
                            $profileQuery
                                ->where('graduation_year', 'like', "%{$search}%")
                                ->orWhere('program', 'like', "%{$search}%")
                                ->orWhere('company', 'like', "%{$search}%")
                                ->orWhere('location', 'like', "%{$search}%")
                                ->orWhere('job_title', 'like', "%{$search}%")
                                ->orWhere('skills', 'like', "%{$search}%")
                                ->orWhere('contact_number', 'like', "%{$search}%");
                        });
                });
            })
            ->latest('user_id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.alumni-profiles.index', compact('alumni', 'search'));
    }

    public function show(User $user)
    {
        abort_if($user->role !== 'alumni', 404);

        $user->load('alumniProfile');

        return view('admin.alumni-profiles.show', compact('user'));
    }
}