<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'message' => 'PCA Admin API v1.0',
        'service' => 'pca-admin-api',
        'status' => 'running',
        'timestamp' => now()->toISOString(),
    ]);
});

Route::get('/docs', function () {
    return response()->json([
        'message' => 'Admin API Documentation will be available here',
        'endpoints' => [
            'GET /api/health' => 'Health check',
            'POST /api/v1/auth/login' => 'Admin login',
            'GET /api/v1/dashboard/stats' => 'Dashboard statistics (auth required)',
            'GET /api/v1/students' => 'Students management (auth required)',
            'GET /api/v1/courses' => 'Courses management (auth required)',
            'GET /api/v1/analytics' => 'Analytics data (auth required)',
        ]
    ]);
});