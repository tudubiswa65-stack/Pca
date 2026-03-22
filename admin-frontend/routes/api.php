<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Health check endpoint for Railway
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'service' => 'pca-admin-frontend',
        'timestamp' => now()->toISOString(),
        'uptime' => uptime(),
    ]);
});

// API routes for admin panel AJAX calls
Route::prefix('api')->group(function () {
    // Admin panel API endpoints (requires authentication)
    Route::middleware(['auth:admin', 'admin.ip'])->group(function () {
        Route::get('/dashboard/metrics', function () {
            return response()->json(['message' => 'Admin dashboard metrics endpoint']);
        });
        
        Route::get('/students/search', function () {
            return response()->json(['message' => 'Student search endpoint']);
        });
        
        Route::get('/reports/generate', function () {
            return response()->json(['message' => 'Report generation endpoint']);
        });
        
        Route::get('/settings/system', function () {
            return response()->json(['message' => 'System settings endpoint']);
        });
    });
});

// Helper function for uptime
if (!function_exists('uptime')) {
    function uptime() {
        return shell_exec('uptime -p') ?: 'unknown';
    }
}