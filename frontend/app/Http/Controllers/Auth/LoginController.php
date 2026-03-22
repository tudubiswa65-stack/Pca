<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request)
    {
        $key = 'login.' . $request->ip();
        
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            throw ValidationException::withMessages([
                'credential' => "Too many login attempts. Please try again in {$seconds} seconds.",
            ]);
        }

        $credential = $request->credential;
        $password = $request->password;

        // Find user by email or phone
        $user = User::where(function ($query) use ($credential) {
            $query->where('email', $credential)
                  ->orWhere('phone', $credential);
        })->first();

        if (!$user || !Hash::check($password, $user->password)) {
            RateLimiter::hit($key, 300); // 5 minutes
            throw ValidationException::withMessages([
                'credential' => 'Invalid credentials provided.',
            ]);
        }

        if ($user->status !== 'active') {
            throw ValidationException::withMessages([
                'credential' => 'Your account is not active. Please verify your phone number.',
            ]);
        }

        RateLimiter::clear($key);

        Auth::login($user);
        $user->update(['last_login_at' => now()]);

        $request->session()->regenerate();

        // Redirect based on role
        return match($user->role) {
            'student' => redirect()->route('student.dashboard'),
            'admin', 'super_admin' => redirect()->route('admin.dashboard'),
            'staff' => redirect()->route('staff.dashboard'),
            default => redirect()->route('student.dashboard'),
        };
    }

    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login')->with('success', 'Logged out successfully.');
    }
}