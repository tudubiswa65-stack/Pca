<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Models\Student;
use App\Services\OtpService;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function __construct(
        private OtpService $otpService,
        private SmsService $smsService
    ) {}

    public function create()
    {
        return view('auth.register');
    }

    public function store(RegisterRequest $request)
    {
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

        session(['registration_phone' => $user->phone]);

        return redirect()->route('otp.show')->with('success', 'Registration successful! Please verify your phone number with the OTP sent to ' . $user->phone);
    }
}