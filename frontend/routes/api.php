<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Health check endpoint for Railway
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'service' => 'pca-frontend',
        'timestamp' => now()->toISOString(),
        'uptime' => uptime(),
    ]);
});

// API routes for frontend AJAX calls
Route::prefix('api')->group(function () {
    // Public API endpoints
    Route::get('/courses/featured', function () {
        return response()->json(['message' => 'Featured courses endpoint']);
    });
    
    Route::post('/contact', function () {
        return response()->json(['message' => 'Contact form submission endpoint']);
    });
    
    Route::post('/newsletter/subscribe', function () {
        return response()->json(['message' => 'Newsletter subscription endpoint']);
    });
    
    // Student portal API (requires authentication)
    Route::middleware('auth')->group(function () {
        Route::get('/student/dashboard', function () {
            return response()->json(['message' => 'Student dashboard data endpoint']);
        });
    });
});

// Helper function for uptime
if (!function_exists('uptime')) {
    function uptime() {
        return shell_exec('uptime -p') ?: 'unknown';
    }
}