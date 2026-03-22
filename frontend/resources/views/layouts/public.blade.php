<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Padmabati Computer Academy')</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: {
                            900: '#0A1628',
                            800: '#1A2238',
                            700: '#2D3748',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-navy-900 min-h-screen">
    <!-- Flash Messages -->
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-transition class="fixed top-4 right-4 bg-teal-600 text-white px-6 py-4 rounded-lg shadow-lg z-50">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('success') }}
                </div>
                <button @click="show = false" class="ml-4 text-white hover:text-gray-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div x-data="{ show: true }" x-show="show" x-transition class="fixed top-4 right-4 bg-red-600 text-white px-6 py-4 rounded-lg shadow-lg z-50">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    {{ session('error') }}
                </div>
                <button @click="show = false" class="ml-4 text-white hover:text-gray-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <div class="flex items-center justify-center min-h-screen px-4 py-12">
        @yield('content')
    </div>

    <!-- Auto-hide flash messages -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const messages = document.querySelectorAll('[x-data*="show: true"]');
            messages.forEach(message => {
                setTimeout(() => {
                    const alpine = message._x_dataStack?.[0];
                    if (alpine) alpine.show = false;
                }, 5000);
            });
        });
    </script>
</body>
</html>