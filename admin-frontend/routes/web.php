<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('admin.login');
});

Route::get('/login', function () {
    return view('admin.login');
});

// Admin panel routes (require authentication and IP check)
Route::middleware(['auth:admin', 'admin.ip'])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    });
    
    Route::get('/students', function () {
        return view('admin.students.index');
    });
    
    Route::get('/courses', function () {
        return view('admin.courses.index');
    });
    
    Route::get('/analytics', function () {
        return view('admin.analytics');
    });
    
    Route::get('/settings', function () {
        return view('admin.settings');
    });
    
    Route::get('/reports', function () {
        return view('admin.reports');
    });
});