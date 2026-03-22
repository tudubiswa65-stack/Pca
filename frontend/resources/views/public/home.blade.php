@extends('layouts.public')

@section('title', 'Home - Padmabati Computer Academy')

@section('content')
<!-- Hero Section -->
<section class="relative min-h-screen flex items-center justify-center overflow-hidden">
    <!-- Background with pattern -->
    <div class="absolute inset-0 bg-gradient-to-br from-[#0A1628] via-[#1A2238] to-[#0A1628]"></div>
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-20 left-20 w-32 h-32 border border-amber-500/20 rounded-full animate-pulse"></div>
        <div class="absolute bottom-40 right-20 w-24 h-24 border border-teal-500/20 rounded-full animate-bounce"></div>
        <div class="absolute top-1/3 right-1/3 w-16 h-16 border border-amber-500/30 rotate-45"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="mb-8">
            <span class="inline-flex items-center px-4 py-2 bg-amber-500/20 text-amber-400 text-sm font-medium rounded-full mb-6">
                <i class="fas fa-star mr-2"></i>
                Rated 4.8/5 on JustDial
            </span>
        </div>
        
        <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold text-white mb-6 leading-tight">
            Master <span class="text-amber-400">Digital Skills</span><br>
            Shape Your <span class="text-teal-400">Future</span>
        </h1>
        
        <p class="text-xl text-gray-300 mb-8 max-w-2xl mx-auto leading-relaxed">
            Join Padmabati Computer Academy and unlock your potential with industry-relevant courses taught by expert instructors.
        </p>
        
        <div class="flex flex-col sm:flex-row gap-4 justify-center mb-12">
            <a href="{{ route('courses.index') }}" 
               class="inline-flex items-center px-8 py-4 bg-amber-500 hover:bg-amber-600 text-white font-semibold rounded-xl transition transform hover:scale-105">
                <i class="fas fa-play mr-2"></i>
                Explore Courses
            </a>
            <a href="{{ route('admission.create') }}" 
               class="inline-flex items-center px-8 py-4 border-2 border-teal-500 text-teal-400 hover:bg-teal-500 hover:text-white font-semibold rounded-xl transition">
                <i class="fas fa-user-plus mr-2"></i>
                Enroll Now
            </a>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-2 md:grid-cols-3 gap-8 max-w-3xl mx-auto">
            <x-stat-counter value="{{ $stats['students'] }}" label="Happy Students" suffix="+" icon="fas fa-users" />
            <x-stat-counter value="{{ $stats['courses'] }}" label="Courses" suffix="+" icon="fas fa-graduation-cap" />
            <x-stat-counter value="{{ $stats['years'] }}" label="Years Experience" suffix="+" icon="fas fa-trophy" />
        </div>
    </div>
</section>

<!-- Featured Courses -->
<section class="py-20 bg-[#0A1628]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
                Popular <span class="text-amber-400">Courses</span>
            </h2>
            <p class="text-gray-400 text-lg max-w-2xl mx-auto">
                Choose from our comprehensive range of computer courses designed to boost your career prospects
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
            @foreach($courses as $course)
                <x-course-card :course="$course" />
            @endforeach
        </div>

        <div class="text-center">
            <a href="{{ route('courses.index') }}" 
               class="inline-flex items-center px-8 py-3 bg-teal-500 hover:bg-teal-600 text-white font-semibold rounded-xl transition">
                View All Courses
                <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>
</section>

<!-- Why Choose Us -->
<section class="py-20 bg-gradient-to-r from-[#1A2238] to-[#0A1628]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
                Why Choose <span class="text-amber-400">Padmabati Academy</span>?
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="text-center group">
                <div class="w-16 h-16 bg-amber-500/20 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-amber-500/30 transition">
                    <i class="fas fa-chalkboard-teacher text-amber-500 text-2xl"></i>
                </div>
                <h3 class="text-white font-semibold text-lg mb-2">Expert Instructors</h3>
                <p class="text-gray-400 text-sm">Learn from industry professionals with years of practical experience</p>
            </div>
            
            <div class="text-center group">
                <div class="w-16 h-16 bg-teal-500/20 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-teal-500/30 transition">
                    <i class="fas fa-laptop-code text-teal-500 text-2xl"></i>
                </div>
                <h3 class="text-white font-semibold text-lg mb-2">Hands-on Learning</h3>
                <p class="text-gray-400 text-sm">Practice with real projects and build a portfolio that stands out</p>
            </div>
            
            <div class="text-center group">
                <div class="w-16 h-16 bg-purple-500/20 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-purple-500/30 transition">
                    <i class="fas fa-certificate text-purple-500 text-2xl"></i>
                </div>
                <h3 class="text-white font-semibold text-lg mb-2">Industry Certification</h3>
                <p class="text-gray-400 text-sm">Get recognized certificates that boost your career prospects</p>
            </div>
            
            <div class="text-center group">
                <div class="w-16 h-16 bg-green-500/20 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-green-500/30 transition">
                    <i class="fas fa-user-tie text-green-500 text-2xl"></i>
                </div>
                <h3 class="text-white font-semibold text-lg mb-2">Job Assistance</h3>
                <p class="text-gray-400 text-sm">Get placement support and career guidance from our experts</p>
            </div>
        </div>
    </div>
</section>

<!-- Latest Notices -->
<section class="py-20 bg-[#0A1628]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-12">
            <div>
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
                    Latest <span class="text-amber-400">Notices</span>
                </h2>
                <p class="text-gray-400">Stay updated with our announcements and important information</p>
            </div>
            <a href="{{ route('notices.index') }}" 
               class="text-teal-400 hover:text-teal-300 font-medium">
                View All →
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($notices as $notice)
                <x-notice-item :notice="$notice" />
            @empty
                <div class="col-span-full text-center py-12">
                    <i class="fas fa-bell-slash text-gray-500 text-4xl mb-4"></i>
                    <p class="text-gray-400">No notices available at the moment</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Gallery Preview -->
<section class="py-20 bg-gradient-to-r from-[#1A2238] to-[#0A1628]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-12">
            <div>
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
                    Our <span class="text-amber-400">Gallery</span>
                </h2>
                <p class="text-gray-400">Glimpse into our vibrant learning environment</p>
            </div>
            <a href="{{ route('gallery.index') }}" 
               class="text-teal-400 hover:text-teal-300 font-medium">
                View All →
            </a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @forelse($gallery as $item)
                <x-gallery-item :gallery="$item" />
            @empty
                <div class="col-span-full text-center py-12">
                    <i class="fas fa-images text-gray-500 text-4xl mb-4"></i>
                    <p class="text-gray-400">No gallery images available</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-gradient-to-r from-amber-600 to-amber-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
            Ready to Start Your Digital Journey?
        </h2>
        <p class="text-amber-100 text-lg mb-8 max-w-2xl mx-auto">
            Join thousands of successful students who transformed their careers with our expert-led courses
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('admission.create') }}" 
               class="inline-flex items-center px-8 py-4 bg-white text-amber-600 font-semibold rounded-xl hover:bg-gray-100 transition">
                <i class="fas fa-user-plus mr-2"></i>
                Apply for Admission
            </a>
            <a href="{{ route('contact.index') }}" 
               class="inline-flex items-center px-8 py-4 border-2 border-white text-white font-semibold rounded-xl hover:bg-white hover:text-amber-600 transition">
                <i class="fas fa-phone mr-2"></i>
                Contact Us
            </a>
        </div>
    </div>
</section>
@endsection