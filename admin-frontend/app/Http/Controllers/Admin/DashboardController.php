<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Payment;
use App\Models\Enquiry;
use App\Models\Feedback;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_students' => User::where('role', 'student')->count(),
            'revenue_this_month' => Payment::whereMonth('created_at', now()->month)->sum('amount'),
            'pending_fees' => User::where('role', 'student')->sum('pending_fees'),
            'open_complaints' => Feedback::where('type', 'complaint')->where('status', 'open')->count(),
        ];

        $monthlyEnrolments = User::where('role', 'student')
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->pluck('count', 'month');

        return view('admin.dashboard', compact('stats', 'monthlyEnrolments'));
    }
}