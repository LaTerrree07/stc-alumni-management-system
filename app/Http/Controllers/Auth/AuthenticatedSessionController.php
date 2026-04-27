<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): RedirectResponse
    {
        return redirect()->route('alumni.login');
    }

    public function createAdmin(): View
    {
        return view('auth.admin-login');
    }

    public function createAlumni(): View
    {
        return view('auth.alumni-login');
    }

    public function storeAdmin(LoginRequest $request): RedirectResponse
    {
        return $this->authenticateByRole(
            request: $request,
            expectedRole: 'admin',
            redirectRoute: 'admin.dashboard',
            errorMessage: 'These credentials do not match an admin account.'
        );
    }

    public function storeAlumni(LoginRequest $request): RedirectResponse
    {
        return $this->authenticateByRole(
            request: $request,
            expectedRole: 'alumni',
            redirectRoute: 'alumni.dashboard',
            errorMessage: 'These credentials do not match an alumni account.'
        );
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        return $this->storeAlumni($request);
    }

    private function authenticateByRole(
        LoginRequest $request,
        string $expectedRole,
        string $redirectRoute,
        string $errorMessage
    ): RedirectResponse {
        $request->authenticate();

        $user = Auth::user();

        if (! $user || $user->role !== $expectedRole) {
            Auth::guard('web')->logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            throw ValidationException::withMessages([
                'email' => $errorMessage,
            ]);
        }

        if (! empty($user->status) && $user->status !== 'active') {
            Auth::guard('web')->logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            throw ValidationException::withMessages([
                'email' => 'Your account is not active. Please contact the system administrator.',
            ]);
        }

        $request->session()->regenerate();

        return redirect()->intended(route($redirectRoute, absolute: false));
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('landing');
    }
}