<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Student Portal') - Padmabati Computer Academy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="h-full bg-gray-50" x-data="{ sidebarOpen: false }">
    <div class="flex h-full">
        <!-- Sidebar -->
        <div class="fixed inset-y-0 left-0 z-50 w-64 bg-[#0A1628] transform transition-transform duration-300 ease-in-out lg:transform-none lg:static lg:inset-0"
             :class="{ '-translate-x-full': !sidebarOpen, 'translate-x-0': sidebarOpen }">
            
            <!-- Logo -->
            <div class="flex items-center justify-center h-16 px-4 bg-[#0A1628]">
                <span class="text-xl font-bold text-white">PCA Student</span>
            </div>
            
            <!-- Navigation -->
            <nav class="mt-8">
                <div class="px-4">
                    <ul class="space-y-2">
                        <li><a href="{{ route('student.dashboard') }}" class="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-gray-700 {{ request()->routeIs('student.dashboard') ? 'bg-amber-500 text-white' : '' }}">
                            <span class="mr-3">📊</span> Dashboard
                        </a></li>
                        <li><a href="#" class="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-gray-700">
                            <span class="mr-3">👤</span> My Profile
                        </a></li>
                        <li><a href="#" class="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-gray-700">
                            <span class="mr-3">📚</span> My Courses
                        </a></li>
                        <li><a href="#" class="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-gray-700">
                            <span class="mr-3">📅</span> Attendance
                        </a></li>
                        <li><a href="#" class="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-gray-700">
                            <span class="mr-3">📄</span> Study Materials
                        </a></li>
                        <li><a href="#" class="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-gray-700">
                            <span class="mr-3">💰</span> Fees
                        </a></li>
                        <li><a href="#" class="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-gray-700">
                            <span class="mr-3">📊</span> My Results
                        </a></li>
                        <li><a href="#" class="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-gray-700">
                            <span class="mr-3">📢</span> Notices
                        </a></li>
                        <li><a href="#" class="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-gray-700">
                            <span class="mr-3">🏆</span> Certificates
                        </a></li>
                        <li><a href="#" class="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-gray-700">
                            <span class="mr-3">💬</span> Feedback
                        </a></li>
                        <li><a href="#" class="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-gray-700">
                            <span class="mr-3">⚙️</span> Settings
                        </a></li>
                    </ul>
                </div>
            </nav>
        </div>
        
        <!-- Mobile overlay -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false" 
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-40 bg-gray-600 bg-opacity-75 lg:hidden" style="display: none;"></div>

        <!-- Main content -->
        <div class="flex flex-col flex-1 lg:ml-0">
            <!-- Top navbar -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="flex items-center justify-between px-6 py-4">
                    <button @click="sidebarOpen = true" class="lg:hidden">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-900 font-medium">{{ Auth::user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-gray-500 hover:text-gray-700">Logout</button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Page content -->
            <main class="flex-1 overflow-y-auto">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>