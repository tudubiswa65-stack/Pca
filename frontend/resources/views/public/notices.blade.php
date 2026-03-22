@extends('layouts.public')

@section('title', 'Notices - Padmabati Computer Academy')

@section('content')
<div class="pt-24 pb-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                Latest <span class="text-amber-400">Notices</span>
            </h1>
            <p class="text-gray-400 text-lg max-w-2xl mx-auto">
                Stay updated with our announcements, course schedules, and important information
            </p>
        </div>

        <!-- Search and Filter -->
        <div class="mb-8">
            <form method="GET" class="max-w-2xl mx-auto">
                <div class="flex flex-col md:flex-row gap-4">
                    <!-- Search Input -->
                    <div class="flex-1 relative">
                        <input type="text" 
                               name="search" 
                               value="{{ $search }}"
                               placeholder="Search notices..."
                               class="w-full bg-white/10 border border-white/20 rounded-lg px-4 py-3 pl-12 text-white placeholder-gray-400 focus:outline-none focus:border-amber-500 transition">
                        <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>

                    <!-- Type Filter -->
                    @if($types->isNotEmpty())
                        <select name="type" 
                                class="bg-white/10 border border-white/20 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-amber-500 transition">
                            <option value="">All Types</option>
                            @foreach($types as $typeOption)
                                <option value="{{ $typeOption }}" {{ $type === $typeOption ? 'selected' : '' }}>
                                    {{ ucfirst($typeOption) }}
                                </option>
                            @endforeach
                        </select>
                    @endif

                    <!-- Search Button -->
                    <button type="submit" 
                            class="px-6 py-3 bg-amber-500 hover:bg-amber-600 text-white font-medium rounded-lg transition">
                        <i class="fas fa-search mr-2"></i>
                        Search
                    </button>
                </div>
            </form>
        </div>

        <!-- Active Filters Display -->
        @if($search || $type)
            <div class="mb-6 flex flex-wrap items-center gap-2">
                <span class="text-gray-400 text-sm">Active filters:</span>
                
                @if($search)
                    <span class="inline-flex items-center px-3 py-1 bg-amber-500/20 text-amber-400 rounded-full text-sm">
                        Search: "{{ $search }}"
                        <a href="{{ route('notices.index', array_filter(['type' => $type])) }}" 
                           class="ml-2 text-amber-300 hover:text-white">
                            <i class="fas fa-times"></i>
                        </a>
                    </span>
                @endif
                
                @if($type)
                    <span class="inline-flex items-center px-3 py-1 bg-teal-500/20 text-teal-400 rounded-full text-sm">
                        Type: {{ ucfirst($type) }}
                        <a href="{{ route('notices.index', array_filter(['search' => $search])) }}" 
                           class="ml-2 text-teal-300 hover:text-white">
                            <i class="fas fa-times"></i>
                        </a>
                    </span>
                @endif
                
                <a href="{{ route('notices.index') }}" 
                   class="text-gray-400 hover:text-white text-sm transition">
                    Clear all
                </a>
            </div>
        @endif

        <!-- Notices Grid -->
        @if($notices->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
                @foreach($notices as $notice)
                    <x-notice-item :notice="$notice" />
                @endforeach
            </div>

            <!-- Pagination -->
            @if($notices->hasPages())
                <div class="flex justify-center">
                    {{ $notices->withQueryString()->links() }}
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="text-center py-20">
                <div class="w-24 h-24 bg-white/10 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-bell-slash text-gray-500 text-3xl"></i>
                </div>
                <h3 class="text-white text-2xl font-semibold mb-4">No Notices Found</h3>
                <p class="text-gray-400 mb-8">
                    @if($search || $type)
                        No notices match your search criteria. Try adjusting your filters or search term.
                    @else
                        No notices are available at the moment. Please check back later for updates.
                    @endif
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    @if($search || $type)
                        <a href="{{ route('notices.index') }}" 
                           class="inline-flex items-center px-6 py-3 bg-amber-500 hover:bg-amber-600 text-white font-medium rounded-lg transition">
                            <i class="fas fa-bell mr-2"></i>
                            View All Notices
                        </a>
                    @endif
                    <a href="{{ route('contact.index') }}" 
                       class="inline-flex items-center px-6 py-3 border border-teal-500 text-teal-400 hover:bg-teal-500 hover:text-white font-medium rounded-lg transition">
                        <i class="fas fa-phone mr-2"></i>
                        Contact Us
                    </a>
                </div>
            </div>
        @endif

        <!-- Subscribe Section -->
        <div class="mt-16 bg-gradient-to-r from-amber-500/20 to-teal-500/20 border border-amber-500/30 rounded-2xl p-8 text-center">
            <h2 class="text-white text-2xl font-bold mb-4">Never Miss an Update!</h2>
            <p class="text-gray-300 mb-6 max-w-2xl mx-auto">
                Join our community to receive instant notifications about new courses, admissions, events, and important announcements.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('admission.create') }}" 
                   class="inline-flex items-center px-6 py-3 bg-amber-500 hover:bg-amber-600 text-white font-medium rounded-lg transition">
                    <i class="fas fa-bell mr-2"></i>
                    Get Notifications
                </a>
                <a href="{{ route('contact.index') }}" 
                   class="inline-flex items-center px-6 py-3 border border-teal-500 text-teal-400 hover:bg-teal-500 hover:text-white font-medium rounded-lg transition">
                    <i class="fas fa-envelope mr-2"></i>
                    Contact Us
                </a>
            </div>
        </div>
    </div>
</div>

<style>
/* Custom pagination styles */
.pagination {
    @apply flex items-center space-x-2;
}

.pagination .page-link {
    @apply px-3 py-2 bg-white/10 text-gray-300 rounded-lg hover:bg-white/20 hover:text-white transition;
}

.pagination .page-item.active .page-link {
    @apply bg-amber-500 text-white;
}

.pagination .page-item.disabled .page-link {
    @apply bg-white/5 text-gray-500 cursor-not-allowed;
}
</style>
@endsection