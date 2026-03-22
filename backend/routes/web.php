<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'message' => 'PCA Student API v1.0',
        'service' => 'pca-student-api',
        'status' => 'running',
        'timestamp' => now()->toISOString(),
    ]);
});

Route::get('/docs', function () {
    return response()->json([
        'message' => 'API Documentation will be available here',
        'endpoints' => [
            'GET /api/health' => 'Health check',
            'POST /api/v1/auth/login' => 'Student login',
            'POST /api/v1/auth/register' => 'Student registration',
            'GET /api/v1/profile' => 'Student profile (auth required)',
            'GET /api/v1/courses' => 'Student courses (auth required)',
            'GET /api/v1/assignments' => 'Student assignments (auth required)',
        ]
    ]);
});