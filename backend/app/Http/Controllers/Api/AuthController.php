<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Student;
use App\Services\OtpService;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function __construct(
        private OtpService $otpService,
        private SmsService $smsService
    ) {}

    /**
     * Register a new user
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|regex:/^[\p{L} .]+$/u|max:100',
            'phone' => 'required|regex:/^[6-9][0-9]{9}$/|unique:users',
            'email' => 'nullable|email|max:191|unique:users',
            'password' => 'required|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'student',
            'status' => 'inactive',
        ]);

        // Create student record
        Student::create([
            'user_id' => $user->id,
            'student_id' => 'PCA' . str_pad($user->id, 6, '0', STR_PAD_LEFT),
            'name' => $user->name,
            'phone' => $user->phone,
            'email' => $user->email,
            'status' => 'pending',
        ]);

        // Generate and send OTP
        $otp = $this->otpService->generate($user->phone);
        $this->smsService->send(
            $user->phone,
            "Welcome to Padmabati Computer Academy! Your OTP for account verification is: {$otp}. Valid for 10 minutes."
        );

        return response()->json([
            'message' => 'Registration successful! Please verify your phone number with the OTP sent.',
            'phone' => $user->phone,
            'user_id' => $user->id,
        ], 201);
    }

    /**
     * Login user
     */
    public function login(Request $request)
    {
        $request->validate([
            'credential' => 'required|string',
            'password' => 'required',
        ]);

        $key = 'api.login.' . $request->ip();
        
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

        $user->update(['last_login_at' => now()]);

        // Create token
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'role' => $user->role,
                'status' => $user->status,
            ],
            'token' => $token,
        ]);
    }

    /**
     * Verify OTP and activate account
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|regex:/^[6-9][0-9]{9}$/',
            'otp' => 'required|digits:6',
        ]);

        if (!$this->otpService->verify($request->phone, $request->otp)) {
            throw ValidationException::withMessages([
                'otp' => 'Invalid or expired OTP. Please try again.',
            ]);
        }

        $user = User::where('phone', $request->phone)->first();
        
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Update user status and phone verification
        $user->update([
            'status' => 'active',
            'phone_verified_at' => now(),
        ]);

        // Update student status if exists
        if ($user->student) {
            $user->student->update(['status' => 'active']);
        }

        // Create token
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'message' => 'Account verified successfully',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'role' => $user->role,
                'status' => $user->status,
            ],
            'token' => $token,
        ]);
    }

    /**
     * Resend OTP
     */
    public function resendOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|regex:/^[6-9][0-9]{9}$/',
        ]);

        $key = 'api.otp.resend.' . $request->ip();
        
        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            throw ValidationException::withMessages([
                'phone' => "Too many resend attempts. Please try again in {$seconds} seconds.",
            ]);
        }

        $user = User::where('phone', $request->phone)->first();
        
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        RateLimiter::hit($key, 600); // 10 minutes

        $otp = $this->otpService->generate($user->phone);
        $this->smsService->send(
            $user->phone,
            "Your new OTP for Padmabati Computer Academy is: {$otp}. Valid for 10 minutes."
        );

        return response()->json(['message' => 'OTP resent successfully']);
    }

    /**
     * Get user profile
     */
    public function profile(Request $request)
    {
        $user = $request->user();
        
        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'role' => $user->role,
                'status' => $user->status,
                'phone_verified_at' => $user->phone_verified_at,
                'last_login_at' => $user->last_login_at,
                'created_at' => $user->created_at,
            ]
        ]);
    }

    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        
        return response()->json(['message' => 'Logged out successfully']);
    }

    /**
     * Forgot password - send OTP
     */
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'phone' => 'required|regex:/^[6-9][0-9]{9}$/',
        ]);

        $user = User::where('phone', $request->phone)->first();
        
        if (!$user) {
            throw ValidationException::withMessages([
                'phone' => 'No account found with this phone number.',
            ]);
        }

        $otp = $this->otpService->generate($user->phone);
        $this->smsService->send(
            $user->phone,
            "Your password reset OTP for Padmabati Computer Academy is: {$otp}. Valid for 10 minutes."
        );

        return response()->json(['message' => 'OTP sent to your phone number']);
    }

    /**
     * Reset password
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'phone' => 'required|regex:/^[6-9][0-9]{9}$/',
            'otp' => 'required|digits:6',
            'password' => 'required|min:8',
        ]);

        if (!$this->otpService->verify($request->phone, $request->otp)) {
            throw ValidationException::withMessages([
                'otp' => 'Invalid or expired OTP. Please try again.',
            ]);
        }

        $user = User::where('phone', $request->phone)->first();
        
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['message' => 'Password reset successfully']);
    }
}