<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\OtpService;
use App\Services\SmsService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class PasswordResetController extends Controller
{
    public function __construct(
        private OtpService $otpService,
        private SmsService $smsService
    ) {}

    public function create()
    {
        return view('auth.forgot-password');
    }

    public function sendOtp(Request $request)
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

        session(['reset_phone' => $user->phone]);

        return redirect()->route('password.reset.form')->with('success', 'OTP sent to your phone number.');
    }

    public function reset()
    {
        $phone = session('reset_phone');
        
        if (!$phone) {
            return redirect()->route('password.request')->with('error', 'Session expired. Please try again.');
        }

        return view('auth.reset-password', compact('phone'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
            'password' => 'required|min:8|confirmed',
        ]);

        $phone = session('reset_phone');
        
        if (!$phone) {
            return redirect()->route('password.request')->with('error', 'Session expired. Please try again.');
        }

        if (!$this->otpService->verify($phone, $request->otp)) {
            throw ValidationException::withMessages([
                'otp' => 'Invalid or expired OTP. Please try again.',
            ]);
        }

        $user = User::where('phone', $phone)->first();
        
        if (!$user) {
            return redirect()->route('password.request')->with('error', 'User not found.');
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        session()->forget('reset_phone');

        return redirect()->route('login')->with('success', 'Password reset successfully. Please login with your new password.');
    }
}