@extends('layouts.public')

@section('title', 'Contact Us - Padmabati Computer Academy')

@section('content')
<div class="pt-24 pb-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                Contact <span class="text-amber-400">Us</span>
            </h1>
            <p class="text-gray-400 text-lg max-w-2xl mx-auto">
                Have questions? We'd love to hear from you. Get in touch with our team for any inquiries.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            
            <!-- Contact Form -->
            <div class="lg:col-span-2">
                <div class="bg-white/5 border border-white/10 rounded-2xl p-8">
                    <h2 class="text-2xl font-bold text-white mb-6">Send us a message</h2>
                    
                    <form method="POST" action="{{ route('contact.store') }}" class="space-y-6">
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

                        <div>
                            <label for="course_interest" class="block text-white font-medium mb-2">Interested Course</label>
                            <select name="course_interest" 
                                    id="course_interest"
                                    class="w-full bg-white/10 border border-white/20 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-amber-500 transition">
                                <option value="">Select a course (optional)</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}" {{ old('course_interest') == $course->id ? 'selected' : '' }}>
                                        {{ $course->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="message" class="block text-white font-medium mb-2">Message *</label>
                            <textarea id="message" 
                                      name="message" 
                                      rows="5" 
                                      required
                                      placeholder="Tell us how we can help you..."
                                      class="w-full bg-white/10 border border-white/20 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:border-amber-500 transition resize-none
                                             @error('message') border-red-500 @enderror">{{ old('message') }}</textarea>
                            @error('message')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" 
                                class="w-full bg-amber-500 hover:bg-amber-600 text-white font-semibold py-3 rounded-lg transition transform hover:scale-105">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Send Message
                        </button>
                    </form>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="space-y-8">
                
                <!-- Contact Details -->
                <div class="bg-white/5 border border-white/10 rounded-2xl p-6">
                    <h3 class="text-white font-bold text-xl mb-6">Contact Information</h3>
                    
                    <div class="space-y-4">
                        <div class="flex items-start space-x-4">
                            <div class="w-10 h-10 bg-amber-500/20 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-map-marker-alt text-amber-500"></i>
                            </div>
                            <div>
                                <h4 class="text-white font-semibold">Address</h4>
                                <p class="text-gray-400 text-sm">
                                    123 Tech Street<br>
                                    Digital City, State 123456<br>
                                    India
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="w-10 h-10 bg-teal-500/20 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-phone text-teal-500"></i>
                            </div>
                            <div>
                                <h4 class="text-white font-semibold">Phone</h4>
                                <p class="text-gray-400 text-sm">+91 98765 43210</p>
                                <p class="text-gray-400 text-sm">+91 87654 32109</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="w-10 h-10 bg-blue-500/20 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-envelope text-blue-500"></i>
                            </div>
                            <div>
                                <h4 class="text-white font-semibold">Email</h4>
                                <p class="text-gray-400 text-sm">info@padmabatiacademy.com</p>
                                <p class="text-gray-400 text-sm">admission@padmabatiacademy.com</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="w-10 h-10 bg-purple-500/20 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-clock text-purple-500"></i>
                            </div>
                            <div>
                                <h4 class="text-white font-semibold">Office Hours</h4>
                                <p class="text-gray-400 text-sm">Monday - Saturday</p>
                                <p class="text-gray-400 text-sm">9:00 AM - 6:00 PM</p>
                                <p class="text-gray-400 text-sm text-xs mt-1">Closed on Sundays</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Social Links -->
                <div class="bg-white/5 border border-white/10 rounded-2xl p-6">
                    <h3 class="text-white font-bold text-xl mb-6">Follow Us</h3>
                    
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center hover:bg-blue-700 transition">
                            <i class="fab fa-facebook-f text-white"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-blue-400 rounded-full flex items-center justify-center hover:bg-blue-500 transition">
                            <i class="fab fa-twitter text-white"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center hover:from-purple-600 hover:to-pink-600 transition">
                            <i class="fab fa-instagram text-white"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-blue-800 rounded-full flex items-center justify-center hover:bg-blue-900 transition">
                            <i class="fab fa-linkedin-in text-white"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-red-600 rounded-full flex items-center justify-center hover:bg-red-700 transition">
                            <i class="fab fa-youtube text-white"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="bg-white/5 border border-white/10 rounded-2xl p-6">
                    <h3 class="text-white font-bold text-xl mb-6">Quick Actions</h3>
                    
                    <div class="space-y-3">
                        <a href="{{ route('admission.create') }}" 
                           class="block w-full bg-amber-500 hover:bg-amber-600 text-white text-center py-3 rounded-lg font-medium transition">
                            <i class="fas fa-user-plus mr-2"></i>
                            Apply for Admission
                        </a>
                        <a href="{{ route('courses.index') }}" 
                           class="block w-full border border-teal-500 text-teal-400 hover:bg-teal-500 hover:text-white text-center py-3 rounded-lg font-medium transition">
                            <i class="fas fa-graduation-cap mr-2"></i>
                            Browse Courses
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Map Section -->
        <div class="mt-16">
            <div class="bg-white/5 border border-white/10 rounded-2xl p-6">
                <h3 class="text-white font-bold text-xl mb-6">Find Us on Map</h3>
                <div class="relative h-64 md:h-96 bg-gray-800 rounded-lg overflow-hidden">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3151.8354345093703!2d144.9537353153167!3d-37.81627997975195!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad65d43f3f5f4e5%3A0x5045675218ce6e0!2sUniversity%20of%20Melbourne!5e0!3m2!1sen!2sau!4v1635745834542!5m2!1sen!2sau" 
                        width="100%" 
                        height="100%" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade"
                        class="rounded-lg">
                    </iframe>
                    <div class="absolute inset-0 bg-[#0A1628]/20"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection