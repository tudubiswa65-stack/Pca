<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AdmissionController;
use App\Http\Controllers\CertificateController;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/courses', [CoursesController::class, 'index'])->name('courses.index');
Route::get('/courses/{slug}', [CoursesController::class, 'show'])->name('courses.show');
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');
Route::get('/notices', [NoticeController::class, 'publicIndex'])->name('notices.index');
Route::get('/notices/{id}', [NoticeController::class, 'show'])->name('notices.show');
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
Route::post('/reviews/store', [ReviewController::class, 'store'])->name('reviews.store');
Route::get('/admission', [AdmissionController::class, 'create'])->name('admission.create');
Route::post('/admission', [AdmissionController::class, 'store'])->name('admission.store');
Route::get('/verify/{qrToken}', [CertificateController::class, 'verify'])->name('certificate.verify');

Route::get('/about', function () {
    return view('about');
});

// Authentication Routes
Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'store']);
Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);

Route::get('/otp-verify', [OtpController::class, 'show'])->name('otp.show');
Route::post('/otp-verify', [OtpController::class, 'verify'])->name('otp.verify');
Route::post('/otp/resend', [OtpController::class, 'resend'])->name('otp.resend');

Route::get('/forgot-password', [PasswordResetController::class, 'create'])->name('password.request');
Route::post('/forgot-password', [PasswordResetController::class, 'sendOtp'])->name('password.email');
Route::get('/forgot-password/reset', [PasswordResetController::class, 'reset'])->name('password.reset.form');
Route::post('/forgot-password/reset', [PasswordResetController::class, 'update'])->name('password.reset');

// Backward compatibility routes (redirect to new auth routes)
Route::get('/student/login', function () {
    return redirect()->route('login');
});

Route::get('/student/register', function () {
    return redirect()->route('register');
});

// Student portal routes (require authentication)
Route::middleware(['auth', 'student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', function () {
        return view('student.dashboard');
    })->name('dashboard');
    
    Route::get('/courses', function () {
        return view('student.courses');
    })->name('courses');
    
    Route::get('/profile', function () {
        return view('student.profile');
    })->name('profile');
});

// Admin portal routes (require authentication)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
});

// Staff portal routes (require authentication)
Route::middleware(['auth', 'staff'])->prefix('staff')->name('staff.')->group(function () {
    Route::get('/dashboard', function () {
        return view('staff.dashboard');
    })->name('dashboard');
});