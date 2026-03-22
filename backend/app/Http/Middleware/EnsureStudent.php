<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureStudent
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || Auth::user()->role !== 'student') {
            return redirect()->route('login')->with('error', 'Please login to access your dashboard.');
        }
        return $next($request);
    }
}