<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - PCA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: '#1e3a8a',
                        amber: '#f59e0b'
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-navy text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <h1 class="text-2xl font-bold text-amber">PCA ADMIN PANEL</h1>
                <div class="flex items-center space-x-4">
                    <span>Welcome, {{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-600 px-4 py-2 rounded">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-lg">
            <nav class="p-4">
                <div class="space-y-6">
                    <div>
                        <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wide">OVERVIEW</h3>
                        <div class="mt-2 space-y-1">
                            <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 text-gray-700 hover:bg-navy hover:text-white rounded">Dashboard</a>
                        </div>
                    </div>
                    
                    <div>
                        <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wide">ACADEMICS</h3>
                        <div class="mt-2 space-y-1">
                            <a href="{{ route('admin.students.index') }}" class="block px-3 py-2 text-gray-700 hover:bg-navy hover:text-white rounded">Students</a>
                            <a href="{{ route('admin.batches.index') }}" class="block px-3 py-2 text-gray-700 hover:bg-navy hover:text-white rounded">Batches</a>
                            <a href="{{ route('admin.courses.index') }}" class="block px-3 py-2 text-gray-700 hover:bg-navy hover:text-white rounded">Courses</a>
                            <a href="{{ route('admin.attendance.index') }}" class="block px-3 py-2 text-gray-700 hover:bg-navy hover:text-white rounded">Attendance</a>
                            <a href="{{ route('admin.results.index') }}" class="block px-3 py-2 text-gray-700 hover:bg-navy hover:text-white rounded">Results</a>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wide">COMMUNICATION</h3>
                        <div class="mt-2 space-y-1">
                            <a href="{{ route('admin.notices.index') }}" class="block px-3 py-2 text-gray-700 hover:bg-navy hover:text-white rounded">Notices</a>
                            <a href="{{ route('admin.materials.index') }}" class="block px-3 py-2 text-gray-700 hover:bg-navy hover:text-white rounded">Materials</a>
                            <a href="{{ route('admin.feedback.index') }}" class="block px-3 py-2 text-gray-700 hover:bg-navy hover:text-white rounded">Feedback</a>
                            <a href="{{ route('admin.enquiries.index') }}" class="block px-3 py-2 text-gray-700 hover:bg-navy hover:text-white rounded">Enquiries</a>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wide">CONTENT</h3>
                        <div class="mt-2 space-y-1">
                            <a href="{{ route('admin.gallery.index') }}" class="block px-3 py-2 text-gray-700 hover:bg-navy hover:text-white rounded">Gallery</a>
                            <a href="{{ route('admin.payments.index') }}" class="block px-3 py-2 text-gray-700 hover:bg-navy hover:text-white rounded">Payments</a>
                            <a href="{{ route('admin.certificates.index') }}" class="block px-3 py-2 text-gray-700 hover:bg-navy hover:text-white rounded">Certificates</a>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wide">SETTINGS</h3>
                        <div class="mt-2 space-y-1">
                            <a href="{{ route('admin.reports.index') }}" class="block px-3 py-2 text-gray-700 hover:bg-navy hover:text-white rounded">Reports</a>
                            <a href="{{ route('admin.settings.index') }}" class="block px-3 py-2 text-gray-700 hover:bg-navy hover:text-white rounded">Settings</a>
                            <a href="{{ route('admin.staff.index') }}" class="block px-3 py-2 text-gray-700 hover:bg-navy hover:text-white rounded">Staff</a>
                        </div>
                    </div>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6">
            @yield('content')
        </main>
    </div>
</body>
</html>