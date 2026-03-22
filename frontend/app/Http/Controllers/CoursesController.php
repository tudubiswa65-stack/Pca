<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Batch;
use Illuminate\Http\Request;

class CoursesController extends Controller
{
    public function index()
    {
        $courses = Course::published()->showOnWebsite()->get()->groupBy('category');
        return view('public.courses', compact('courses'));
    }

    public function show(string $slug)
    {
        $course = Course::where('slug', $slug)->where('status', 'published')->firstOrFail();
        $batches = Batch::where('course_id', $course->id)->where('status', 'active')->get();
        return view('public.course-detail', compact('course', 'batches'));
    }
}