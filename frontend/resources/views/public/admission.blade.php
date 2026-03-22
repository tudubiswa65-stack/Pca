@extends('layouts.public')

@section('title', 'Admission Application - Padmabati Computer Academy')

@section('content')
<div class="pt-24 pb-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                Apply for <span class="text-amber-400">Admission</span>
            </h1>
            <p class="text-gray-400 text-lg max-w-2xl mx-auto">
                Take the first step towards your digital career. Fill out the form below to apply for admission.
            </p>
        </div>

        <!-- Admission Form -->
        <div class="bg-white/5 border border-white/10 rounded-2xl p-8">
            <h2 class="text-2xl font-bold text-white mb-6">Admission Application Form</h2>
            
            <form method="POST" action="{{ route('admission.store') }}" class="space-y-6">
                @csrf
                
                <!-- Personal Information -->
                <div class="border-b border-white/10 pb-6">
                    <h3 class="text-lg font-semibold text-white mb-4">Personal Information</h3>
                    
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
                            <label for="date_of_birth" class="block text-white font-medium mb-2">Date of Birth *</label>
                            <input type="date" 
                                   id="date_of_birth" 
                                   name="date_of_birth" 
                                   value="{{ old('date_of_birth') }}"
                                   required
                                   max="{{ date('Y-m-d', strtotime('-16 years')) }}"
                                   class="w-full bg-white/10 border border-white/20 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-amber-500 transition
                                          @error('date_of_birth') border-red-500 @enderror">
                            @error('date_of_birth')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
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
                        
                        <div>
                            <label for="phone" class="block text-white font-medium mb-2">Phone Number *</label>
                            <input type="tel" 
                                   id="phone" 
                                   name="phone" 
                                   value="{{ old('phone') }}"
                                   required
                                   class="w-full bg-white/10 border border-white/20 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:border-amber-500 transition
                                          @error('phone') border-red-500 @enderror">
                            @error('phone')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-6">
                        <label for="address" class="block text-white font-medium mb-2">Address *</label>
                        <textarea id="address" 
                                  name="address" 
                                  rows="3" 
                                  required
                                  placeholder="Your complete address..."
                                  class="w-full bg-white/10 border border-white/20 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:border-amber-500 transition resize-none
                                         @error('address') border-red-500 @enderror">{{ old('address') }}</textarea>
                        @error('address')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Educational Background -->
                <div class="border-b border-white/10 pb-6">
                    <h3 class="text-lg font-semibold text-white mb-4">Educational Background</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="qualification" class="block text-white font-medium mb-2">Highest Qualification *</label>
                            <select name="qualification" 
                                    id="qualification"
                                    required
                                    class="w-full bg-white/10 border border-white/20 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-amber-500 transition
                                           @error('qualification') border-red-500 @enderror">
                                <option value="">Select your qualification</option>
                                <option value="10th" {{ old('qualification') === '10th' ? 'selected' : '' }}>10th Standard</option>
                                <option value="12th" {{ old('qualification') === '12th' ? 'selected' : '' }}>12th Standard</option>
                                <option value="diploma" {{ old('qualification') === 'diploma' ? 'selected' : '' }}>Diploma</option>
                                <option value="bachelors" {{ old('qualification') === 'bachelors' ? 'selected' : '' }}>Bachelor's Degree</option>
                                <option value="masters" {{ old('qualification') === 'masters' ? 'selected' : '' }}>Master's Degree</option>
                                <option value="others" {{ old('qualification') === 'others' ? 'selected' : '' }}>Others</option>
                            </select>
                            @error('qualification')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="computer_experience" class="block text-white font-medium mb-2">Computer Experience *</label>
                            <select name="computer_experience" 
                                    id="computer_experience"
                                    required
                                    class="w-full bg-white/10 border border-white/20 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-amber-500 transition
                                           @error('computer_experience') border-red-500 @enderror">
                                <option value="">Select your experience level</option>
                                <option value="beginner" {{ old('computer_experience') === 'beginner' ? 'selected' : '' }}>Beginner</option>
                                <option value="intermediate" {{ old('computer_experience') === 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                                <option value="advanced" {{ old('computer_experience') === 'advanced' ? 'selected' : '' }}>Advanced</option>
                            </select>
                            @error('computer_experience')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Course Selection -->
                <div class="border-b border-white/10 pb-6">
                    <h3 class="text-lg font-semibold text-white mb-4">Course Selection</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="course_interest" class="block text-white font-medium mb-2">Interested Course *</label>
                            <select name="course_interest" 
                                    id="course_interest"
                                    required
                                    class="w-full bg-white/10 border border-white/20 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-amber-500 transition
                                           @error('course_interest') border-red-500 @enderror">
                                <option value="">Select a course</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}" 
                                            data-fee="{{ $course->fee }}" 
                                            data-duration="{{ $course->duration_months }}"
                                            {{ old('course_interest') == $course->id ? 'selected' : '' }}>
                                        {{ $course->name }} - ₹{{ number_format($course->fee) }} ({{ $course->duration_months }} months)
                                    </option>
                                @endforeach
                            </select>
                            @error('course_interest')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="preferred_timing" class="block text-white font-medium mb-2">Preferred Timing *</label>
                            <select name="preferred_timing" 
                                    id="preferred_timing"
                                    required
                                    class="w-full bg-white/10 border border-white/20 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-amber-500 transition
                                           @error('preferred_timing') border-red-500 @enderror">
                                <option value="">Select preferred timing</option>
                                <option value="morning" {{ old('preferred_timing') === 'morning' ? 'selected' : '' }}>Morning (9 AM - 12 PM)</option>
                                <option value="afternoon" {{ old('preferred_timing') === 'afternoon' ? 'selected' : '' }}>Afternoon (12 PM - 3 PM)</option>
                                <option value="evening" {{ old('preferred_timing') === 'evening' ? 'selected' : '' }}>Evening (3 PM - 6 PM)</option>
                            </select>
                            @error('preferred_timing')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Course Info Display -->
                    <div id="course-info" class="mt-6 p-4 bg-amber-500/10 border border-amber-500/30 rounded-lg hidden">
                        <h4 class="text-amber-400 font-semibold mb-2">Course Details:</h4>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-gray-400">Fee:</span>
                                <span class="text-white" id="selected-fee">-</span>
                            </div>
                            <div>
                                <span class="text-gray-400">Duration:</span>
                                <span class="text-white" id="selected-duration">-</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Information -->
                <div>
                    <h3 class="text-lg font-semibold text-white mb-4">Additional Information</h3>
                    
                    <div>
                        <label for="message" class="block text-white font-medium mb-2">Additional Message (Optional)</label>
                        <textarea id="message" 
                                  name="message" 
                                  rows="4" 
                                  placeholder="Tell us about your goals, expectations, or any specific requirements..."
                                  class="w-full bg-white/10 border border-white/20 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:border-amber-500 transition resize-none">{{ old('message') }}</textarea>
                    </div>
                </div>

                <!-- Terms and Submit -->
                <div class="border-t border-white/10 pt-6">
                    <div class="bg-blue-500/10 border border-blue-500/30 rounded-lg p-4 mb-6">
                        <div class="flex items-start space-x-3">
                            <i class="fas fa-info-circle text-blue-400 mt-1"></i>
                            <div class="text-blue-400 text-sm">
                                <p class="font-medium mb-2">Important Information:</p>
                                <ul class="list-disc list-inside space-y-1 text-xs">
                                    <li>All fields marked with * are mandatory</li>
                                    <li>We will contact you within 24 hours to confirm your application</li>
                                    <li>Course fees can be paid in installments</li>
                                    <li>Admission is subject to availability and meeting course requirements</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <button type="submit" 
                            class="w-full bg-amber-500 hover:bg-amber-600 text-white font-semibold py-4 rounded-lg transition transform hover:scale-105">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Submit Application
                    </button>
                </div>
            </form>
        </div>

        <!-- Contact Info -->
        <div class="mt-12 text-center">
            <p class="text-gray-400 mb-4">Have questions? Contact us directly:</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="tel:+919876543210" 
                   class="inline-flex items-center px-4 py-2 bg-white/10 text-white rounded-lg hover:bg-white/20 transition">
                    <i class="fas fa-phone mr-2"></i>
                    +91 98765 43210
                </a>
                <a href="mailto:admission@padmabatiacademy.com" 
                   class="inline-flex items-center px-4 py-2 bg-white/10 text-white rounded-lg hover:bg-white/20 transition">
                    <i class="fas fa-envelope mr-2"></i>
                    admission@padmabatiacademy.com
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    // Course selection handler
    document.getElementById('course_interest').addEventListener('change', function() {
        const selected = this.selectedOptions[0];
        const courseInfo = document.getElementById('course-info');
        
        if (selected.value) {
            const fee = selected.dataset.fee;
            const duration = selected.dataset.duration;
            
            document.getElementById('selected-fee').textContent = '₹' + Number(fee).toLocaleString();
            document.getElementById('selected-duration').textContent = duration + ' months';
            
            courseInfo.classList.remove('hidden');
        } else {
            courseInfo.classList.add('hidden');
        }
    });
    
    // Trigger on page load if there's an old value
    if (document.getElementById('course_interest').value) {
        document.getElementById('course_interest').dispatchEvent(new Event('change'));
    }
</script>
@endsection