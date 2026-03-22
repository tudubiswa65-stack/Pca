@extends('layouts.public')

@section('title', $course->name . ' - Padmabati Computer Academy')

@section('content')
<div class="pt-24 pb-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumb -->
        <nav class="mb-8" aria-label="Breadcrumb">
            <div class="flex items-center space-x-2 text-sm text-gray-400">
                <a href="/" class="hover:text-white transition">Home</a>
                <i class="fas fa-chevron-right text-xs"></i>
                <a href="{{ route('courses.index') }}" class="hover:text-white transition">Courses</a>
                <i class="fas fa-chevron-right text-xs"></i>
                <span class="text-white">{{ $course->name }}</span>
            </div>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Course Header -->
                <div class="mb-8">
                    <div class="flex items-center mb-4">
                        <div class="text-5xl mr-4">{{ $course->icon ?? '💻' }}</div>
                        <div>
                            <span class="inline-block bg-teal-500/20 text-teal-400 text-sm px-3 py-1 rounded-full mb-2">
                                {{ ucfirst($course->category) }}
                            </span>
                            <h1 class="text-3xl md:text-4xl font-bold text-white">{{ $course->name }}</h1>
                        </div>
                    </div>
                    <p class="text-gray-400 text-lg leading-relaxed">{{ $course->description }}</p>
                </div>

                <!-- Course Details -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                    <div class="bg-white/5 border border-white/10 rounded-lg p-4 text-center">
                        <i class="fas fa-clock text-amber-500 text-xl mb-2"></i>
                        <div class="text-white font-semibold">Duration</div>
                        <div class="text-gray-400 text-sm">{{ $course->duration_months }} months</div>
                    </div>
                    
                    <div class="bg-white/5 border border-white/10 rounded-lg p-4 text-center">
                        <i class="fas fa-rupee-sign text-amber-500 text-xl mb-2"></i>
                        <div class="text-white font-semibold">Course Fee</div>
                        <div class="text-gray-400 text-sm">₹{{ number_format($course->fee) }}</div>
                    </div>
                    
                    <div class="bg-white/5 border border-white/10 rounded-lg p-4 text-center">
                        <i class="fas fa-users text-amber-500 text-xl mb-2"></i>
                        <div class="text-white font-semibold">Batch Size</div>
                        <div class="text-gray-400 text-sm">15-20 students</div>
                    </div>
                    
                    <div class="bg-white/5 border border-white/10 rounded-lg p-4 text-center">
                        <i class="fas fa-certificate text-amber-500 text-xl mb-2"></i>
                        <div class="text-white font-semibold">Certificate</div>
                        <div class="text-gray-400 text-sm">Included</div>
                    </div>
                </div>

                <!-- Syllabus -->
                @if($course->syllabus)
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-white mb-6">Course Syllabus</h2>
                        
                        <div x-data="{ activeModule: 0 }" class="space-y-4">
                            @foreach($course->syllabus as $index => $module)
                                <div class="bg-white/5 border border-white/10 rounded-lg overflow-hidden">
                                    <button @click="activeModule = activeModule === {{ $index }} ? -1 : {{ $index }}"
                                            class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-white/10 transition">
                                        <div class="flex items-center">
                                            <span class="bg-amber-500/20 text-amber-400 w-8 h-8 rounded-full flex items-center justify-center text-sm font-semibold mr-4">
                                                {{ $index + 1 }}
                                            </span>
                                            <h3 class="text-white font-semibold">{{ $module['title'] ?? 'Module ' . ($index + 1) }}</h3>
                                        </div>
                                        <i class="fas fa-chevron-down text-gray-400 transform transition-transform" 
                                           :class="activeModule === {{ $index }} ? 'rotate-180' : ''"></i>
                                    </button>
                                    
                                    <div x-show="activeModule === {{ $index }}" 
                                         x-transition.opacity.duration.300ms
                                         class="px-6 pb-4">
                                        @if(isset($module['topics']) && is_array($module['topics']))
                                            <ul class="space-y-2">
                                                @foreach($module['topics'] as $topic)
                                                    <li class="flex items-center text-gray-400 text-sm">
                                                        <i class="fas fa-check-circle text-teal-400 text-xs mr-2"></i>
                                                        {{ $topic }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <p class="text-gray-400 text-sm">{{ $module['description'] ?? 'Module content will be covered in detail.' }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- What You'll Learn -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-white mb-6">What You'll Learn</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex items-start">
                            <i class="fas fa-check-circle text-teal-400 mt-1 mr-3"></i>
                            <span class="text-gray-400">Comprehensive understanding of core concepts</span>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-check-circle text-teal-400 mt-1 mr-3"></i>
                            <span class="text-gray-400">Hands-on experience with real projects</span>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-check-circle text-teal-400 mt-1 mr-3"></i>
                            <span class="text-gray-400">Industry best practices and standards</span>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-check-circle text-teal-400 mt-1 mr-3"></i>
                            <span class="text-gray-400">Professional portfolio development</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Enrollment Card -->
                <div class="bg-white/5 border border-white/10 rounded-xl p-6 mb-8 sticky top-24">
                    <div class="text-center mb-6">
                        <div class="text-3xl font-bold text-white mb-2">₹{{ number_format($course->fee) }}</div>
                        <div class="text-gray-400">Full Course Fee</div>
                    </div>

                    <div class="space-y-4 mb-6">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-400">Duration:</span>
                            <span class="text-white">{{ $course->duration_months }} months</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-400">Mode:</span>
                            <span class="text-white">Offline</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-400">Certificate:</span>
                            <span class="text-white">Yes</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-400">Job Assistance:</span>
                            <span class="text-white">Included</span>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <a href="{{ route('admission.create') }}" 
                           class="block w-full bg-amber-500 hover:bg-amber-600 text-white text-center py-3 rounded-lg font-semibold transition">
                            Enroll Now
                        </a>
                        <a href="{{ route('contact.index') }}" 
                           class="block w-full border border-teal-500 text-teal-400 hover:bg-teal-500 hover:text-white text-center py-3 rounded-lg font-medium transition">
                            Ask Questions
                        </a>
                    </div>
                </div>

                <!-- Available Batches -->
                @if($batches->isNotEmpty())
                    <div class="bg-white/5 border border-white/10 rounded-xl p-6">
                        <h3 class="text-white font-semibold text-lg mb-4">Available Batches</h3>
                        
                        <div class="space-y-3">
                            @foreach($batches as $batch)
                                <div class="bg-white/10 rounded-lg p-4">
                                    <div class="flex justify-between items-start mb-2">
                                        <h4 class="text-white font-medium">{{ $batch->name }}</h4>
                                        <span class="text-xs px-2 py-1 rounded-full 
                                                   {{ $batch->available_slots > 5 ? 'bg-green-500/20 text-green-400' : 
                                                      ($batch->available_slots > 0 ? 'bg-yellow-500/20 text-yellow-400' : 'bg-red-500/20 text-red-400') }}">
                                            {{ $batch->available_slots }} slots
                                        </span>
                                    </div>
                                    <div class="text-gray-400 text-sm">
                                        <div>Start: {{ $batch->start_date->format('M d, Y') }}</div>
                                        @if($batch->schedule)
                                            <div>Schedule: {{ implode(', ', $batch->schedule) }}</div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection