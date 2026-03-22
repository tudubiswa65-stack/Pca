@extends('layouts.student')

@section('title', 'Student Dashboard - Padmabati Computer Academy')

@section('content')
<div class="p-6">
    <!-- Welcome Banner -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Welcome back, {{ $user->name }}! 👋</h1>
            <p class="text-gray-500 mt-1">Here's your academic overview for today</p>
        </div>
        @if($student && $student->photo_url)
            <img src="{{ $student->photo_url }}" class="w-14 h-14 rounded-full object-cover border-4 border-amber-400" alt="Profile">
        @else
            <div class="w-14 h-14 rounded-full bg-amber-500 flex items-center justify-center text-white text-xl font-bold">
                {{ substr($user->name, 0, 1) }}
            </div>
        @endif
    </div>
    
    <!-- KPI Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <!-- Attendance -->
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-3">
                <span class="text-gray-500 text-sm font-medium">Attendance</span>
                <span class="text-teal-500 text-2xl">📊</span>
            </div>
            <div class="text-3xl font-bold text-gray-900">{{ $attendancePct }}%</div>
            <div class="text-gray-400 text-xs mt-1">{{ $presentCount }}/{{ $totalDays }} days this month</div>
            @if($attendancePct < 75)
                <div class="mt-2 text-xs text-red-500 font-medium">⚠️ Below 75% minimum</div>
            @endif
        </div>
        
        <!-- Course Progress -->
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-3">
                <span class="text-gray-500 text-sm font-medium">Course Progress</span>
                <span class="text-blue-500 text-2xl">📚</span>
            </div>
            <div class="text-3xl font-bold text-gray-900">{{ $enrolment ? 'Active' : 'N/A' }}</div>
            <div class="text-gray-400 text-xs mt-1">{{ $enrolment?->course?->name ?? 'No course' }}</div>
        </div>
        
        <!-- Next Class -->
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-3">
                <span class="text-gray-500 text-sm font-medium">Next Class</span>
                <span class="text-amber-500 text-2xl">📅</span>
            </div>
            <div class="text-xl font-bold text-gray-900">Check Schedule</div>
            <div class="text-gray-400 text-xs mt-1">View batch schedule</div>
        </div>
        
        <!-- Fee Balance -->
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-3">
                <span class="text-gray-500 text-sm font-medium">Fee Balance</span>
                <span class="{{ $feeBalance > 0 ? 'text-red-500' : 'text-green-500' }} text-2xl">💰</span>
            </div>
            <div class="text-3xl font-bold {{ $feeBalance > 0 ? 'text-red-500' : 'text-green-500' }}">₹{{ number_format($feeBalance) }}</div>
            <div class="text-gray-400 text-xs mt-1">{{ $feeBalance > 0 ? 'Outstanding balance' : 'Fully paid' }}</div>
        </div>
    </div>
    
    <!-- Recent Notices -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Latest Notices</h2>
        @forelse($notices as $notice)
            <div class="flex items-start space-x-3 py-3 {{ !$loop->last ? 'border-b border-gray-100' : '' }}">
                <span class="px-2 py-1 text-xs rounded-full {{ $notice->type === 'urgent' ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700' }}">{{ ucfirst($notice->type ?? 'info') }}</span>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate">{{ $notice->title }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">{{ $notice->publish_at ? \Carbon\Carbon::parse($notice->publish_at)->format('d M Y') : '' }}</p>
                </div>
            </div>
        @empty
            <p class="text-gray-400 text-sm">No notices at this time.</p>
        @endforelse
    </div>
</div>
@endsection