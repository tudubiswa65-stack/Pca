<?php

namespace App\Http\Controllers;

use App\Models\Enquiry;
use App\Models\Course;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function index()
    {
        $courses = Course::published()->get(['id', 'name']);
        $settings = SiteSetting::all()->pluck('value', 'key');
        
        return view('public.contact', compact('courses', 'settings'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'message' => 'required|string|max:1000',
            'course_interest' => 'nullable|exists:courses,id',
            'source' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        Enquiry::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message,
            'course_interest' => $request->course_interest,
            'source' => $request->source ?? 'website',
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Thank you for your enquiry! We will get back to you soon.');
    }
}