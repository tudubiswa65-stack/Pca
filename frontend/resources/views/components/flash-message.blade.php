@if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-transition.opacity.duration.300ms 
         class="fixed top-20 right-4 bg-teal-600 text-white px-6 py-4 rounded-lg shadow-lg z-50 max-w-sm">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-3 text-lg"></i>
                <span class="text-sm">{{ session('success') }}</span>
            </div>
            <button @click="show = false" class="ml-4 text-white hover:text-gray-200 transition">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
@endif

@if(session('error'))
    <div x-data="{ show: true }" x-show="show" x-transition.opacity.duration.300ms 
         class="fixed top-20 right-4 bg-red-600 text-white px-6 py-4 rounded-lg shadow-lg z-50 max-w-sm">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle mr-3 text-lg"></i>
                <span class="text-sm">{{ session('error') }}</span>
            </div>
            <button @click="show = false" class="ml-4 text-white hover:text-gray-200 transition">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
@endif

@if(session('warning'))
    <div x-data="{ show: true }" x-show="show" x-transition.opacity.duration.300ms 
         class="fixed top-20 right-4 bg-yellow-600 text-white px-6 py-4 rounded-lg shadow-lg z-50 max-w-sm">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <i class="fas fa-exclamation-triangle mr-3 text-lg"></i>
                <span class="text-sm">{{ session('warning') }}</span>
            </div>
            <button @click="show = false" class="ml-4 text-white hover:text-gray-200 transition">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
@endif

@if(session('info'))
    <div x-data="{ show: true }" x-show="show" x-transition.opacity.duration.300ms 
         class="fixed top-20 right-4 bg-blue-600 text-white px-6 py-4 rounded-lg shadow-lg z-50 max-w-sm">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <i class="fas fa-info-circle mr-3 text-lg"></i>
                <span class="text-sm">{{ session('info') }}</span>
            </div>
            <button @click="show = false" class="ml-4 text-white hover:text-gray-200 transition">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
@endif

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