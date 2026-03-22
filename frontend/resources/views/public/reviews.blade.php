@extends('layouts.public')

@section('title', 'Student Reviews - Padmabati Computer Academy')

@section('content')
<div class="pt-24 pb-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                Student <span class="text-amber-400">Reviews</span>
            </h1>
            <p class="text-gray-400 text-lg max-w-2xl mx-auto">
                Read what our students have to say about their learning experience at Padmabati Computer Academy
            </p>
        </div>

        <!-- Overall Rating Stats -->
        @if($totalReviews > 0)
            <div class="bg-white/5 border border-white/10 rounded-2xl p-8 mb-12">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Average Rating -->
                    <div class="text-center md:text-left">
                        <div class="flex items-center justify-center md:justify-start mb-4">
                            <div class="text-5xl font-bold text-white mr-4">{{ number_format($averageRating, 1) }}</div>
                            <div>
                                <div class="flex items-center mb-1">
                                    <x-star-rating :rating="$averageRating" size="text-lg" />
                                </div>
                                <div class="text-gray-400 text-sm">Based on {{ $totalReviews }} reviews</div>
                            </div>
                        </div>
                    </div>

                    <!-- Rating Breakdown -->
                    <div class="space-y-2">
                        @for($i = 5; $i >= 1; $i--)
                            @php
                                $count = $ratingBreakdown[$i] ?? 0;
                                $percentage = $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0;
                            @endphp
                            <div class="flex items-center space-x-3">
                                <span class="text-white text-sm w-8">{{ $i }} ⭐</span>
                                <div class="flex-1 bg-gray-700 rounded-full h-2">
                                    <div class="bg-amber-500 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                                </div>
                                <span class="text-gray-400 text-sm w-8">{{ $count }}</span>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        @endif

        <!-- Reviews Grid -->
        @if($reviews->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
                @foreach($reviews as $review)
                    <div class="bg-white/5 border border-white/10 rounded-xl p-6">
                        <!-- Review Header -->
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-amber-500 rounded-full flex items-center justify-center text-white font-semibold">
                                    {{ substr($review->name, 0, 1) }}
                                </div>
                                <div>
                                    <h3 class="text-white font-semibold">{{ $review->name }}</h3>
                                    @if($review->course)
                                        <p class="text-gray-400 text-xs">{{ $review->course->name }}</p>
                                    @endif
                                </div>
                            </div>
                            @if($review->is_verified)
                                <span class="bg-green-500/20 text-green-400 text-xs px-2 py-1 rounded-full">Verified</span>
                            @endif
                        </div>

                        <!-- Rating -->
                        <div class="flex items-center mb-4">
                            <x-star-rating :rating="$review->rating" size="text-sm" />
                            <span class="text-gray-400 text-sm ml-2">{{ $review->rating }}/5</span>
                        </div>

                        <!-- Review Content -->
                        <p class="text-gray-400 text-sm leading-relaxed mb-4">{{ $review->message }}</p>

                        <!-- Review Date -->
                        <div class="text-gray-500 text-xs">
                            {{ $review->created_at->diffForHumans() }}
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($reviews->hasPages())
                <div class="flex justify-center mb-12">
                    {{ $reviews->links() }}
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="text-center py-20">
                <div class="w-24 h-24 bg-white/10 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-star text-gray-500 text-3xl"></i>
                </div>
                <h3 class="text-white text-2xl font-semibold mb-4">No Reviews Yet</h3>
                <p class="text-gray-400 mb-8">Be the first to share your experience with Padmabati Computer Academy!</p>
                <a href="#review-form" 
                   class="inline-flex items-center px-6 py-3 bg-amber-500 hover:bg-amber-600 text-white font-medium rounded-lg transition">
                    <i class="fas fa-star mr-2"></i>
                    Write a Review
                </a>
            </div>
        @endif

        <!-- Write Review Form -->
        <div id="review-form" class="bg-white/5 border border-white/10 rounded-2xl p-8">
            <h2 class="text-2xl font-bold text-white mb-6">Write a Review</h2>
            
            <form method="POST" action="{{ route('reviews.store') }}" class="space-y-6">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-white font-medium mb-2">Full Name *</label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}"
                               required
                               class="w-full bg-white/10 border border-white/20 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:border-amber-500 transition
                                      @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="email" class="block text-white font-medium mb-2">Email Address *</label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}"
                               required
                               class="w-full bg-white/10 border border-white/20 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:border-amber-500 transition
                                      @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="course_taken" class="block text-white font-medium mb-2">Course Taken</label>
                    <select name="course_taken" 
                            id="course_taken"
                            class="w-full bg-white/10 border border-white/20 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-amber-500 transition">
                        <option value="">Select a course (optional)</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}" {{ old('course_taken') == $course->id ? 'selected' : '' }}>
                                {{ $course->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="rating" class="block text-white font-medium mb-2">Rating *</label>
                    <div x-data="{ rating: {{ old('rating', 5) }} }" class="flex items-center space-x-2">
                        @for($i = 1; $i <= 5; $i++)
                            <button type="button" 
                                    @click="rating = {{ $i }}"
                                    :class="rating >= {{ $i }} ? 'text-amber-500' : 'text-gray-400'"
                                    class="text-2xl hover:text-amber-500 transition focus:outline-none">
                                ⭐
                            </button>
                        @endfor
                        <span x-text="rating" class="text-white ml-2"></span>
                        <span class="text-gray-400">/ 5</span>
                        <input type="hidden" name="rating" :value="rating">
                    </div>
                    @error('rating')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="message" class="block text-white font-medium mb-2">Your Review *</label>
                    <textarea id="message" 
                              name="message" 
                              rows="5" 
                              required
                              placeholder="Share your experience with us..."
                              class="w-full bg-white/10 border border-white/20 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:border-amber-500 transition resize-none
                                     @error('message') border-red-500 @enderror">{{ old('message') }}</textarea>
                    @error('message')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="bg-amber-500/10 border border-amber-500/30 rounded-lg p-4">
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-info-circle text-amber-500 mt-1"></i>
                        <div class="text-amber-400 text-sm">
                            <p class="font-medium mb-1">Review Guidelines:</p>
                            <ul class="list-disc list-inside space-y-1 text-xs">
                                <li>All reviews are moderated before publication</li>
                                <li>Please be honest and constructive in your feedback</li>
                                <li>Reviews may be verified through course enrollment records</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <button type="submit" 
                        class="w-full bg-amber-500 hover:bg-amber-600 text-white font-semibold py-3 rounded-lg transition transform hover:scale-105">
                    <i class="fas fa-star mr-2"></i>
                    Submit Review
                </button>
            </form>
        </div>

        <!-- Call to Action -->
        <div class="mt-16 bg-gradient-to-r from-amber-500/20 to-teal-500/20 border border-amber-500/30 rounded-2xl p-8 text-center">
            <h2 class="text-white text-2xl font-bold mb-4">Ready to Join Our Success Stories?</h2>
            <p class="text-gray-300 mb-6 max-w-2xl mx-auto">
                Experience quality education and become part of our growing community of successful graduates.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('admission.create') }}" 
                   class="inline-flex items-center px-6 py-3 bg-amber-500 hover:bg-amber-600 text-white font-medium rounded-lg transition">
                    <i class="fas fa-user-plus mr-2"></i>
                    Apply for Admission
                </a>
                <a href="{{ route('courses.index') }}" 
                   class="inline-flex items-center px-6 py-3 border border-teal-500 text-teal-400 hover:bg-teal-500 hover:text-white font-medium rounded-lg transition">
                    <i class="fas fa-graduation-cap mr-2"></i>
                    Browse Courses
                </a>
            </div>
        </div>
    </div>
</div>
@endsection