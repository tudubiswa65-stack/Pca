<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $student = $user->student;
        
        // Mock data for now since we don't have migrations
        $attendancePct = 85;
        $presentCount = 17;
        $totalDays = 20;
        $feeBalance = 5000;
        $notices = [];
        $enrolment = null;
        
        return view('student.dashboard', compact('user', 'student', 'attendancePct', 'presentCount', 'totalDays', 'enrolment', 'feeBalance', 'notices'));
    }
}