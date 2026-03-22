@extends('layouts.public')

@section('title', 'Courses - Padmabati Computer Academy')

@section('content')
<div class="pt-24 pb-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                Our <span class="text-amber-400">Courses</span>
            </h1>
            <p class="text-gray-400 text-lg max-w-2xl mx-auto">
                Choose from our comprehensive range of computer courses designed to boost your career prospects
            </p>
        </div>

        <!-- Filter Tabs -->
        @if($courses->isNotEmpty())
            <div x-data="{ activeCategory: 'all' }" class="mb-12">
                <div class="flex flex-wrap justify-center gap-2 mb-8">
                    <button @click="activeCategory = 'all'" 
                            :class="activeCategory === 'all' ? 'bg-amber-500 text-white' : 'bg-white/10 text-gray-300 hover:bg-white/20'"
                            class="px-6 py-2 rounded-full font-medium transition">
                        All Courses
                    </button>
                    @foreach($courses->keys() as $category)
                        <button @click="activeCategory = '{{ $category }}'" 
                                :class="activeCategory === '{{ $category }}' ? 'bg-amber-500 text-white' : 'bg-white/10 text-gray-300 hover:bg-white/20'"
                                class="px-6 py-2 rounded-full font-medium transition">
                            {{ ucfirst($category) }}
                        </button>
                    @endforeach
                </div>

                @foreach($courses as $category => $categorycourses)
                    <div x-show="activeCategory === 'all' || activeCategory === '{{ $category }}'" 
                         x-transition.opacity.duration.300ms
                         class="mb-16">
                        
                        <div class="flex items-center mb-8">
                            <h2 class="text-2xl font-bold text-white mr-4">{{ ucfirst($category) }}</h2>
                            <div class="flex-1 h-px bg-gradient-to-r from-amber-500/50 to-transparent"></div>
                            <span class="bg-amber-500/20 text-amber-400 px-3 py-1 rounded-full text-sm ml-4">
                                {{ count($categorycourses) }} courses
                            </span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            @foreach($categorycourses as $course)
                                <x-course-card :course="$course" />
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-20">
                <div class="w-24 h-24 bg-white/10 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-graduation-cap text-gray-500 text-3xl"></i>
                </div>
                <h3 class="text-white text-2xl font-semibold mb-4">No Courses Available</h3>
                <p class="text-gray-400 mb-8">We're working on adding new courses. Please check back soon!</p>
                <a href="{{ route('contact.index') }}" 
                   class="inline-flex items-center px-6 py-3 bg-amber-500 hover:bg-amber-600 text-white font-medium rounded-lg transition">
                    Contact Us for Updates
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        @endif

        <!-- Info Cards -->
        <div class="mt-20 grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white/5 border border-white/10 rounded-xl p-6 text-center">
                <div class="w-12 h-12 bg-blue-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-clock text-blue-400 text-xl"></i>
                </div>
                <h3 class="text-white font-semibold text-lg mb-2">Flexible Timing</h3>
                <p class="text-gray-400 text-sm">Choose from morning, afternoon, or evening batches to suit your schedule</p>
            </div>

            <div class="bg-white/5 border border-white/10 rounded-xl p-6 text-center">
                <div class="w-12 h-12 bg-green-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-certificate text-green-400 text-xl"></i>
                </div>
                <h3 class="text-white font-semibold text-lg mb-2">Industry Certification</h3>
                <p class="text-gray-400 text-sm">Receive recognized certificates upon successful completion of courses</p>
            </div>

            <div class="bg-white/5 border border-white/10 rounded-xl p-6 text-center">
                <div class="w-12 h-12 bg-purple-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-handshake text-purple-400 text-xl"></i>
                </div>
                <h3 class="text-white font-semibold text-lg mb-2">Job Assistance</h3>
                <p class="text-gray-400 text-sm">Get placement support and career guidance after course completion</p>
            </div>
        </div>

        <!-- CTA -->
        <div class="mt-20 text-center">
            <div class="bg-gradient-to-r from-amber-500/20 to-teal-500/20 border border-amber-500/30 rounded-2xl p-8">
                <h3 class="text-white text-2xl font-bold mb-4">Ready to Start Learning?</h3>
                <p class="text-gray-300 mb-6">Join our upcoming batches and kickstart your career in technology</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('admission.create') }}" 
                       class="inline-flex items-center px-6 py-3 bg-amber-500 hover:bg-amber-600 text-white font-medium rounded-lg transition">
                        <i class="fas fa-user-plus mr-2"></i>
                        Apply for Admission
                    </a>
                    <a href="{{ route('contact.index') }}" 
                       class="inline-flex items-center px-6 py-3 border border-teal-500 text-teal-400 hover:bg-teal-500 hover:text-white font-medium rounded-lg transition">
                        <i class="fas fa-phone mr-2"></i>
                        Get More Info
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection