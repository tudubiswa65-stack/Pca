<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

// Health check endpoint for Railway
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'service' => 'pca-student-api',
        'timestamp' => now()->toISOString(),
        'uptime' => uptime(),
    ]);
});

// API versioning
Route::prefix('v1')->group(function () {
    // Public authentication routes
    Route::post('/auth/login', [AuthController::class, 'login']);
    Route::post('/auth/register', [AuthController::class, 'register']);
    Route::post('/auth/verify-otp', [AuthController::class, 'verifyOtp']);
    Route::post('/auth/resend-otp', [AuthController::class, 'resendOtp']);
    Route::post('/auth/forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('/auth/reset-password', [AuthController::class, 'resetPassword']);
    
    // Protected routes (requires Sanctum token)
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/auth/profile', [AuthController::class, 'profile']);
        Route::post('/auth/logout', [AuthController::class, 'logout']);
        
        // Student routes
        Route::get('/profile', function (Request $request) {
            return response()->json([
                'message' => 'Student profile endpoint',
                'user' => $request->user()
            ]);
        });
        
        Route::get('/courses', function () {
            return response()->json(['message' => 'Student courses endpoint']);
        });
        
        Route::get('/assignments', function () {
            return response()->json(['message' => 'Student assignments endpoint']);
        });
        
        Route::get('/dashboard', function (Request $request) {
            return response()->json([
                'message' => 'Student dashboard data',
                'user' => $request->user()->only(['name', 'email', 'phone', 'role']),
                'student' => $request->user()->student
            ]);
        });
    });
});

// Helper function for uptime
if (!function_exists('uptime')) {
    function uptime() {
        return shell_exec('uptime -p') ?: 'unknown';
    }
}