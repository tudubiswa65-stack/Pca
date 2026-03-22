<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Feedback::public()
                          ->with('course')
                          ->latest()
                          ->paginate(12);
        
        $averageRating = Feedback::public()->avg('rating');
        $totalReviews = Feedback::public()->count();
        
        $ratingBreakdown = [];
        for ($i = 1; $i <= 5; $i++) {
            $ratingBreakdown[$i] = Feedback::public()->where('rating', $i)->count();
        }
        
        $courses = Course::published()->get(['id', 'name']);
        
        return view('public.reviews', compact('reviews', 'averageRating', 'totalReviews', 'ratingBreakdown', 'courses'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'message' => 'required|string|max:1000',
            'course_taken' => 'nullable|exists:courses,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        Feedback::create([
            'name' => $request->name,
            'email' => $request->email,
            'rating' => $request->rating,
            'message' => $request->message,
            'course_taken' => $request->course_taken,
            'is_verified' => false,
            'is_public' => false,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Thank you for your review! It will be published after verification.');
    }
}