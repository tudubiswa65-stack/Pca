<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\OtpService;
use App\Services\SmsService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class OtpController extends Controller
{
    public function __construct(
        private OtpService $otpService,
        private SmsService $smsService
    ) {}

    public function show(Request $request)
    {
        $phone = session('registration_phone') ?? session('reset_phone');
        
        if (!$phone) {
            return redirect()->route('login')->with('error', 'Session expired. Please try again.');
        }

        return view('auth.otp-verify', compact('phone'));
    }

    public function verify(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $phone = session('registration_phone') ?? session('reset_phone');
        
        if (!$phone) {
            return redirect()->route('login')->with('error', 'Session expired. Please try again.');
        }

        if (!$this->otpService->verify($phone, $request->otp)) {
            throw ValidationException::withMessages([
                'otp' => 'Invalid or expired OTP. Please try again.',
            ]);
        }

        $user = User::where('phone', $phone)->first();
        
        if (!$user) {
            return redirect()->route('register')->with('error', 'User not found. Please register again.');
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

        // Clear session
        session()->forget(['registration_phone', 'reset_phone']);

        // Login user
        Auth::login($user);
        
        return redirect()->route('student.dashboard')->with('success', 'Account verified successfully! Welcome to Padmabati Computer Academy.');
    }

    public function resend(Request $request)
    {
        $key = 'otp.resend.' . $request->ip();
        
        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            throw ValidationException::withMessages([
                'otp' => "Too many resend attempts. Please try again in {$seconds} seconds.",
            ]);
        }

        $phone = session('registration_phone') ?? session('reset_phone');
        
        if (!$phone) {
            return response()->json(['error' => 'Session expired'], 400);
        }

        RateLimiter::hit($key, 600); // 10 minutes

        $otp = $this->otpService->generate($phone);
        $this->smsService->send(
            $phone,
            "Your new OTP for Padmabati Computer Academy is: {$otp}. Valid for 10 minutes."
        );

        return response()->json(['message' => 'OTP resent successfully']);
    }
}