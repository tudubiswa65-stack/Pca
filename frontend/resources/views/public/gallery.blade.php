@extends('layouts.public')

@section('title', 'Gallery - Padmabati Computer Academy')

@section('content')
<div class="pt-24 pb-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                Our <span class="text-amber-400">Gallery</span>
            </h1>
            <p class="text-gray-400 text-lg max-w-2xl mx-auto">
                Take a glimpse into our vibrant learning environment and see our students in action
            </p>
        </div>

        <!-- Category Filter -->
        @if($categories->isNotEmpty())
            <div class="flex flex-wrap justify-center gap-2 mb-8">
                <a href="{{ route('gallery.index') }}" 
                   class="px-4 py-2 rounded-full font-medium transition {{ !$category ? 'bg-amber-500 text-white' : 'bg-white/10 text-gray-300 hover:bg-white/20' }}">
                    All
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('gallery.index', ['category' => $cat]) }}" 
                       class="px-4 py-2 rounded-full font-medium transition {{ $category === $cat ? 'bg-amber-500 text-white' : 'bg-white/10 text-gray-300 hover:bg-white/20' }}">
                        {{ ucfirst($cat) }}
                    </a>
                @endforeach
            </div>
        @endif

        <!-- Gallery Grid -->
        @if($gallery->isNotEmpty())
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-12">
                @foreach($gallery as $item)
                    <x-gallery-item :gallery="$item" />
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-20">
                <div class="w-24 h-24 bg-white/10 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-images text-gray-500 text-3xl"></i>
                </div>
                <h3 class="text-white text-2xl font-semibold mb-4">No Images Found</h3>
                <p class="text-gray-400 mb-8">
                    @if($category)
                        No images found for "{{ $category }}" category. Try browsing all images or select a different category.
                    @else
                        We're working on adding new images to our gallery. Please check back soon!
                    @endif
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    @if($category)
                        <a href="{{ route('gallery.index') }}" 
                           class="inline-flex items-center px-6 py-3 bg-amber-500 hover:bg-amber-600 text-white font-medium rounded-lg transition">
                            <i class="fas fa-images mr-2"></i>
                            View All Images
                        </a>
                    @endif
                    <a href="{{ route('contact.index') }}" 
                       class="inline-flex items-center px-6 py-3 border border-teal-500 text-teal-400 hover:bg-teal-500 hover:text-white font-medium rounded-lg transition">
                        <i class="fas fa-phone mr-2"></i>
                        Contact Us
                    </a>
                </div>
            </div>
        @endif

        <!-- Info Section -->
        <div class="mt-16 bg-gradient-to-r from-amber-500/20 to-teal-500/20 border border-amber-500/30 rounded-2xl p-8 text-center">
            <h2 class="text-white text-2xl font-bold mb-4">Want to Be Part of Our Story?</h2>
            <p class="text-gray-300 mb-6 max-w-2xl mx-auto">
                Join our community of learners and see your success story featured in our gallery. 
                Every achievement, every milestone, every moment of learning matters to us.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('admission.create') }}" 
                   class="inline-flex items-center px-6 py-3 bg-amber-500 hover:bg-amber-600 text-white font-medium rounded-lg transition">
                    <i class="fas fa-user-plus mr-2"></i>
                    Join Our Academy
                </a>
                <a href="{{ route('courses.index') }}" 
                   class="inline-flex items-center px-6 py-3 border border-teal-500 text-teal-400 hover:bg-teal-500 hover:text-white font-medium rounded-lg transition">
                    <i class="fas fa-graduation-cap mr-2"></i>
                    Browse Courses
                </a>
            </div>
        </div>

        <!-- Statistics -->
        <div class="mt-16 grid grid-cols-2 md:grid-cols-4 gap-6">
            <div class="text-center">
                <div class="text-3xl font-bold text-white mb-2">500+</div>
                <div class="text-gray-400 text-sm">Happy Students</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-white mb-2">50+</div>
                <div class="text-gray-400 text-sm">Events Conducted</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-white mb-2">15+</div>
                <div class="text-gray-400 text-sm">Course Programs</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-white mb-2">{{ now()->year - 2020 }}+</div>
                <div class="text-gray-400 text-sm">Years Experience</div>
            </div>
        </div>
    </div>
</div>
@endsection