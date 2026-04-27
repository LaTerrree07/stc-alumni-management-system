<?php

namespace App\Http\Controllers;

use App\Models\AlumniProfile;
use App\Models\User;
use Illuminate\Http\Request;

class AlumniNetworkController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $graduationYear = $request->input('graduation_year');
        $program = $request->input('program');
        $location = $request->input('location');

        $alumni = User::query()
            ->with('alumniProfile')
            ->where('role', 'alumni')
            ->where('status', 'active')
            ->when($search, function ($query, $search) {
                $query->where(function ($userQuery) use ($search) {
                    $userQuery
                        ->where('first_name', 'like', "%{$search}%")
                        ->orWhere('middle_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhereHas('alumniProfile', function ($profileQuery) use ($search) {
                            $profileQuery
                                ->where('program', 'like', "%{$search}%")
                                ->orWhere('graduation_year', 'like', "%{$search}%")
                                ->orWhere('company', 'like', "%{$search}%")
                                ->orWhere('location', 'like', "%{$search}%")
                                ->orWhere('skills', 'like', "%{$search}%")
                                ->orWhere('job_title', 'like', "%{$search}%")
                                ->orWhere('contact_number', 'like', "%{$search}%");
                        });
                });
            })
            ->when($graduationYear, function ($query, $graduationYear) {
                $query->whereHas('alumniProfile', function ($profileQuery) use ($graduationYear) {
                    $profileQuery->where('graduation_year', $graduationYear);
                });
            })
            ->when($program, function ($query, $program) {
                $query->whereHas('alumniProfile', function ($profileQuery) use ($program) {
                    $profileQuery->where('program', $program);
                });
            })
            ->when($location, function ($query, $location) {
                $query->whereHas('alumniProfile', function ($profileQuery) use ($location) {
                    $profileQuery->where('location', $location);
                });
            })
            ->latest('user_id')
            ->paginate(12)
            ->withQueryString();

        $graduationYears = AlumniProfile::query()
            ->whereNotNull('graduation_year')
            ->select('graduation_year')
            ->distinct()
            ->orderByDesc('graduation_year')
            ->pluck('graduation_year');

        $programs = AlumniProfile::query()
            ->whereNotNull('program')
            ->select('program')
            ->distinct()
            ->orderBy('program')
            ->pluck('program');

        $locations = AlumniProfile::query()
            ->whereNotNull('location')
            ->select('location')
            ->distinct()
            ->orderBy('location')
            ->pluck('location');

        return view('alumni-network.index', compact(
            'alumni',
            'search',
            'graduationYear',
            'program',
            'location',
            'graduationYears',
            'programs',
            'locations'
        ));
    }

    public function show(User $user)
    {
        abort_if($user->role !== 'alumni', 404);

        $user->load('alumniProfile');

        return view('alumni-network.show', compact('user'));
    }
}