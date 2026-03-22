<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Health check endpoint for Railway
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'service' => 'pca-admin-api',
        'timestamp' => now()->toISOString(),
        'uptime' => uptime(),
    ]);
});

// API versioning
Route::prefix('v1')->group(function () {
    // Admin authentication routes
    Route::post('/auth/login', function () {
        return response()->json(['message' => 'Admin login endpoint']);
    });
    
    // Admin routes with IP restriction and auth
    Route::middleware(['admin.ip', 'auth:admin'])->group(function () {
        Route::get('/dashboard/stats', function () {
            return response()->json(['message' => 'Admin dashboard stats endpoint']);
        });
        
        Route::get('/students', function () {
            return response()->json(['message' => 'Admin students management endpoint']);
        });
        
        Route::get('/courses', function () {
            return response()->json(['message' => 'Admin courses management endpoint']);
        });
        
        Route::get('/analytics', function () {
            return response()->json(['message' => 'Admin analytics endpoint']);
        });
    });
});

// Helper function for uptime
if (!function_exists('uptime')) {
    function uptime() {
        return shell_exec('uptime -p') ?: 'unknown';
    }
}