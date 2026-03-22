<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Notice;
use App\Models\Gallery;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $courses = Course::published()->showOnWebsite()->limit(6)->get();
        $notices = Notice::published()->latest('publish_at')->limit(5)->get();
        $gallery = Gallery::where('is_public', true)->orderBy('sort_order')->limit(6)->get();
        $settings = SiteSetting::all()->pluck('value', 'key');
        $stats = [
            'students' => \App\Models\User::where('role', 'student')->count() ?: ($settings['stats_total_students'] ?? 500),
            'courses' => Course::published()->count() ?: 15,
            'years' => now()->year - 2020,
        ];
        
        return view('public.home', compact('courses', 'notices', 'gallery', 'settings', 'stats'));
    }
}