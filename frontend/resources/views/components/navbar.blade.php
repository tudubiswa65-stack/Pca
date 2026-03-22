<nav x-data="{ menuOpen: false }" class="fixed top-0 w-full z-50 bg-[#0A1628]/95 backdrop-blur-sm border-b border-white/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <a href="/" class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-amber-500 rounded-lg flex items-center justify-center font-bold text-white text-lg">PCA</div>
                <span class="text-white font-semibold text-lg hidden sm:block">Padmabati Academy</span>
            </a>
            
            <!-- Desktop Nav -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('courses.index') }}" class="text-gray-300 hover:text-amber-400 transition">Courses</a>
                <a href="{{ route('gallery.index') }}" class="text-gray-300 hover:text-amber-400 transition">Gallery</a>
                <a href="{{ route('notices.index') }}" class="text-gray-300 hover:text-amber-400 transition">Notices</a>
                <a href="{{ route('reviews.index') }}" class="text-gray-300 hover:text-amber-400 transition">Reviews</a>
                <a href="{{ route('contact.index') }}" class="text-gray-300 hover:text-amber-400 transition">Contact</a>
            </div>
            
            <!-- Auth buttons -->
            <div class="hidden md:flex items-center space-x-3">
                @auth
                    <a href="{{ route('student.dashboard') }}" class="text-amber-400 hover:text-amber-300">Dashboard</a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button class="text-gray-300 hover:text-white text-sm">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-gray-300 hover:text-white transition">Login</a>
                    <a href="{{ route('admission.create') }}" class="bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition">Enroll Now</a>
                @endauth
            </div>
            
            <!-- Mobile hamburger -->
            <button @click="menuOpen = !menuOpen" class="md:hidden text-white p-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path x-show="!menuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    <path x-show="menuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        
        <!-- Mobile menu -->
        <div x-show="menuOpen" x-transition class="md:hidden pb-4">
            <div class="flex flex-col space-y-2 pt-2 border-t border-white/10">
                <a href="{{ route('courses.index') }}" class="text-gray-300 hover:text-amber-400 py-2 px-2">Courses</a>
                <a href="{{ route('gallery.index') }}" class="text-gray-300 hover:text-amber-400 py-2 px-2">Gallery</a>
                <a href="{{ route('notices.index') }}" class="text-gray-300 hover:text-amber-400 py-2 px-2">Notices</a>
                <a href="{{ route('reviews.index') }}" class="text-gray-300 hover:text-amber-400 py-2 px-2">Reviews</a>
                <a href="{{ route('contact.index') }}" class="text-gray-300 hover:text-amber-400 py-2 px-2">Contact</a>
                @auth
                    <a href="{{ route('student.dashboard') }}" class="text-amber-400 py-2 px-2">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-gray-300 py-2 px-2">Login</a>
                    <a href="{{ route('admission.create') }}" class="bg-amber-500 text-white py-2 px-4 rounded-lg text-center">Enroll Now</a>
                @endauth
            </div>
        </div>
    </div>
</nav>