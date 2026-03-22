<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdmissionController extends Controller
{
    public function create()
    {
        $courses = Course::published()->get(['id', 'name', 'fee', 'duration_months']);
        
        return view('public.admission', compact('courses'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'date_of_birth' => 'required|date|before:today',
            'address' => 'required|string|max:500',
            'qualification' => 'required|string|max:255',
            'course_interest' => 'required|exists:courses,id',
            'preferred_timing' => 'required|string|in:morning,afternoon,evening',
            'computer_experience' => 'required|string|in:beginner,intermediate,advanced',
            'message' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        $course = Course::find($request->course_interest);
        
        $enquiry = Enquiry::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'course_interest' => $request->course_interest,
            'source' => 'admission_form',
            'status' => 'pending',
            'message' => "Admission Application\n\n" .
                       "Date of Birth: {$request->date_of_birth}\n" .
                       "Address: {$request->address}\n" .
                       "Qualification: {$request->qualification}\n" .
                       "Preferred Timing: {$request->preferred_timing}\n" .
                       "Computer Experience: {$request->computer_experience}\n" .
                       "Course: {$course->name}\n\n" .
                       "Additional Message: " . ($request->message ?? 'None'),
        ]);

        return redirect()->back()->with('success', 'Your admission application has been submitted successfully! We will contact you within 24 hours.');
    }
}