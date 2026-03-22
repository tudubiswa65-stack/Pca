@extends('layouts.public')

@section('title', 'Student Dashboard - Padmabati Computer Academy')

@section('content')
<div class="w-full max-w-6xl mx-auto p-4">
    <!-- Header -->
    <div class="bg-white rounded-2xl shadow-xl p-8 mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-navy-900">Welcome back, {{ Auth::user()->name }}!</h1>
                <p class="text-gray-600 mt-2">Student ID: {{ Auth::user()->student->student_id ?? 'N/A' }}</p>
            </div>
            <div class="text-right">
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">
                        <i class="fas fa-sign-out-alt mr-1"></i>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Dashboard Content -->
    <div class="grid md:grid-cols-3 gap-6">
        <!-- Profile Card -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center mb-4">
                <div class="bg-blue-100 p-3 rounded-full">
                    <i class="fas fa-user text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="font-semibold text-gray-800">Profile</h3>
                    <p class="text-gray-600 text-sm">Manage your account</p>
                </div>
            </div>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-600">Name:</span>
                    <span class="font-medium">{{ Auth::user()->name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Phone:</span>
                    <span class="font-medium">{{ Auth::user()->phone }}</span>
                </div>
                @if(Auth::user()->email)
                <div class="flex justify-between">
                    <span class="text-gray-600">Email:</span>
                    <span class="font-medium">{{ Auth::user()->email }}</span>
                </div>
                @endif
                <div class="flex justify-between">
                    <span class="text-gray-600">Status:</span>
                    <span class="inline-block px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">
                        {{ ucfirst(Auth::user()->status) }}
                    </span>
                </div>
            </div>
            <a href="{{ route('student.profile') }}" class="mt-4 w-full bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg text-center block">
                View Profile
            </a>
        </div>

        <!-- Courses Card -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center mb-4">
                <div class="bg-green-100 p-3 rounded-full">
                    <i class="fas fa-graduation-cap text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="font-semibold text-gray-800">My Courses</h3>
                    <p class="text-gray-600 text-sm">View enrolled courses</p>
                </div>
            </div>
            <div class="text-center py-4">
                <div class="text-2xl font-bold text-gray-800">0</div>
                <div class="text-gray-600 text-sm">Enrolled Courses</div>
            </div>
            <a href="{{ route('student.courses') }}" class="mt-4 w-full bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-lg text-center block">
                View Courses
            </a>
        </div>

        <!-- Quick Actions Card -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center mb-4">
                <div class="bg-amber-100 p-3 rounded-full">
                    <i class="fas fa-bolt text-amber-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="font-semibold text-gray-800">Quick Actions</h3>
                    <p class="text-gray-600 text-sm">Common tasks</p>
                </div>
            </div>
            <div class="space-y-2">
                <a href="#" class="block w-full text-left px-3 py-2 text-gray-700 hover:bg-gray-50 rounded-lg">
                    <i class="fas fa-calendar mr-2 text-blue-500"></i>
                    View Schedule
                </a>
                <a href="#" class="block w-full text-left px-3 py-2 text-gray-700 hover:bg-gray-50 rounded-lg">
                    <i class="fas fa-file-alt mr-2 text-green-500"></i>
                    Assignments
                </a>
                <a href="#" class="block w-full text-left px-3 py-2 text-gray-700 hover:bg-gray-50 rounded-lg">
                    <i class="fas fa-chart-line mr-2 text-purple-500"></i>
                    Progress Report
                </a>
                <a href="#" class="block w-full text-left px-3 py-2 text-gray-700 hover:bg-gray-50 rounded-lg">
                    <i class="fas fa-credit-card mr-2 text-orange-500"></i>
                    Fee Payment
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="bg-white rounded-xl shadow-lg p-6 mt-8">
        <h3 class="text-xl font-semibold text-gray-800 mb-4">
            <i class="fas fa-clock mr-2 text-blue-600"></i>
            Recent Activity
        </h3>
        <div class="text-center py-8 text-gray-500">
            <i class="fas fa-inbox text-4xl mb-4 text-gray-300"></i>
            <p>No recent activity to show</p>
        </div>
    </div>
</div>
@endsection