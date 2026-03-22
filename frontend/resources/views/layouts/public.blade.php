<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Padmabati Computer Academy')</title>
    
    <!-- SEO -->
    <x-seo />
    
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
    
    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</head>
<body class="bg-[#0A1628] min-h-screen">
    <!-- Navigation -->
    <x-navbar />
    
    <!-- Flash Messages -->
    <x-flash-message />
    
    <!-- Main Content -->
    <main>
        @yield('content')
    </main>
    
    <!-- Footer -->
    <x-footer />

    <!-- Auto-hide flash messages -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const messages = document.querySelectorAll('[x-data*="show: true"]');
            messages.forEach(message => {
                setTimeout(() => {
                    if (message.__x && message.__x.$data) {
                        message.__x.$data.show = false;
                    }
                }, 5000);
            });
        });
    </script>
</body>
</html>