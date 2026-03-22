<footer class="bg-[#0A1628] border-t border-white/10 mt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            
            <!-- About Section -->
            <div class="space-y-4">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-amber-500 rounded-lg flex items-center justify-center font-bold text-white text-sm">PCA</div>
                    <span class="text-white font-semibold">Padmabati Academy</span>
                </div>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Empowering students with practical computer education and technical skills for a digital future.
                </p>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-amber-400 transition">
                        <i class="fab fa-facebook-f text-lg"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-amber-400 transition">
                        <i class="fab fa-twitter text-lg"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-amber-400 transition">
                        <i class="fab fa-instagram text-lg"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-amber-400 transition">
                        <i class="fab fa-linkedin-in text-lg"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-amber-400 transition">
                        <i class="fab fa-youtube text-lg"></i>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="space-y-4">
                <h3 class="text-white font-semibold text-lg">Quick Links</h3>
                <div class="space-y-2">
                    <a href="{{ route('courses.index') }}" class="block text-gray-400 hover:text-amber-400 transition text-sm">Our Courses</a>
                    <a href="{{ route('admission.create') }}" class="block text-gray-400 hover:text-amber-400 transition text-sm">Admission</a>
                    <a href="{{ route('gallery.index') }}" class="block text-gray-400 hover:text-amber-400 transition text-sm">Gallery</a>
                    <a href="{{ route('notices.index') }}" class="block text-gray-400 hover:text-amber-400 transition text-sm">Notices</a>
                    <a href="{{ route('reviews.index') }}" class="block text-gray-400 hover:text-amber-400 transition text-sm">Reviews</a>
                </div>
            </div>

            <!-- Courses -->
            <div class="space-y-4">
                <h3 class="text-white font-semibold text-lg">Popular Courses</h3>
                <div class="space-y-2">
                    <a href="#" class="block text-gray-400 hover:text-amber-400 transition text-sm">Basic Computer</a>
                    <a href="#" class="block text-gray-400 hover:text-amber-400 transition text-sm">MS Office</a>
                    <a href="#" class="block text-gray-400 hover:text-amber-400 transition text-sm">Web Development</a>
                    <a href="#" class="block text-gray-400 hover:text-amber-400 transition text-sm">Graphic Design</a>
                    <a href="#" class="block text-gray-400 hover:text-amber-400 transition text-sm">Digital Marketing</a>
                </div>
            </div>

            <!-- Contact Info -->
            <div class="space-y-4">
                <h3 class="text-white font-semibold text-lg">Contact Info</h3>
                <div class="space-y-3">
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-map-marker-alt text-amber-500 text-sm mt-1"></i>
                        <div class="text-gray-400 text-sm">
                            <p>123 Tech Street</p>
                            <p>Digital City, State 123456</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-phone text-amber-500 text-sm"></i>
                        <span class="text-gray-400 text-sm">+91 98765 43210</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-envelope text-amber-500 text-sm"></i>
                        <span class="text-gray-400 text-sm">info@padmabatiacademy.com</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-clock text-amber-500 text-sm"></i>
                        <span class="text-gray-400 text-sm">Mon - Sat: 9AM - 6PM</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="mt-8 pt-8 border-t border-white/10 flex flex-col md:flex-row justify-between items-center">
            <p class="text-gray-400 text-sm">
                © {{ date('Y') }} Padmabati Computer Academy. All rights reserved.
            </p>
            <div class="flex space-x-6 mt-4 md:mt-0">
                <a href="#" class="text-gray-400 hover:text-amber-400 text-sm transition">Privacy Policy</a>
                <a href="#" class="text-gray-400 hover:text-amber-400 text-sm transition">Terms of Service</a>
                <a href="#" class="text-gray-400 hover:text-amber-400 text-sm transition">Sitemap</a>
            </div>
        </div>
    </div>
</footer>