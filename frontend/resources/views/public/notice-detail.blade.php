@extends('layouts.public')

@section('title', $notice->title . ' - Padmabati Computer Academy')

@section('content')
<div class="pt-24 pb-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumb -->
        <nav class="mb-8" aria-label="Breadcrumb">
            <div class="flex items-center space-x-2 text-sm text-gray-400">
                <a href="/" class="hover:text-white transition">Home</a>
                <i class="fas fa-chevron-right text-xs"></i>
                <a href="{{ route('notices.index') }}" class="hover:text-white transition">Notices</a>
                <i class="fas fa-chevron-right text-xs"></i>
                <span class="text-white">{{ str($notice->title)->limit(50) }}</span>
            </div>
        </nav>

        <!-- Notice Content -->
        <article class="bg-white/5 border border-white/10 rounded-2xl p-8">
            <!-- Notice Header -->
            <header class="mb-8">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-3">
                        <span class="inline-flex items-center px-3 py-1 text-sm font-medium rounded-full
                            {{ $notice->priority === 'high' ? 'bg-red-500/20 text-red-400' : 
                               ($notice->priority === 'medium' ? 'bg-yellow-500/20 text-yellow-400' : 'bg-green-500/20 text-green-400') }}">
                            {{ ucfirst($notice->priority) }} Priority
                        </span>
                        <span class="inline-flex items-center px-3 py-1 text-sm font-medium bg-blue-500/20 text-blue-400 rounded-full">
                            {{ ucfirst($notice->type) }}
                        </span>
                    </div>
                    
                    <time class="text-gray-400 text-sm">
                        {{ $notice->publish_at->format('F j, Y \a\t g:i A') }}
                    </time>
                </div>
                
                <h1 class="text-3xl md:text-4xl font-bold text-white mb-4 leading-tight">
                    {{ $notice->title }}
                </h1>
                
                <div class="flex items-center text-gray-400 text-sm">
                    <i class="fas fa-user mr-2"></i>
                    <span>Published by {{ $notice->creator->name ?? 'Admin' }}</span>
                    
                    @if($notice->expires_at)
                        <span class="mx-3">•</span>
                        <i class="fas fa-clock mr-2"></i>
                        <span>Expires on {{ $notice->expires_at->format('M j, Y') }}</span>
                    @endif
                </div>
            </header>

            <!-- Notice Content -->
            <div class="prose prose-invert max-w-none">
                <div class="text-gray-300 leading-relaxed">
                    {!! nl2br(e($notice->content)) !!}
                </div>
            </div>

            <!-- Notice Footer -->
            @if($notice->target_audience)
                <footer class="mt-8 pt-6 border-t border-white/10">
                    <div class="bg-amber-500/10 border border-amber-500/30 rounded-lg p-4">
                        <h3 class="text-amber-400 font-semibold mb-2">Target Audience:</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($notice->target_audience as $audience)
                                <span class="inline-flex items-center px-2 py-1 bg-amber-500/20 text-amber-400 rounded-full text-sm">
                                    {{ ucfirst($audience) }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </footer>
            @endif
        </article>

        <!-- Actions -->
        <div class="mt-8 flex flex-col sm:flex-row gap-4">
            <a href="{{ route('notices.index') }}" 
               class="inline-flex items-center px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Notices
            </a>
            
            <div class="flex items-center space-x-2">
                <span class="text-gray-400 text-sm">Share:</span>
                <a href="https://twitter.com/intent/tweet?text={{ urlencode($notice->title) }}&url={{ urlencode(request()->fullUrl()) }}" 
                   target="_blank"
                   class="w-8 h-8 bg-blue-500 hover:bg-blue-600 rounded-full flex items-center justify-center text-white text-sm transition">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" 
                   target="_blank"
                   class="w-8 h-8 bg-blue-600 hover:bg-blue-700 rounded-full flex items-center justify-center text-white text-sm transition">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="https://api.whatsapp.com/send?text={{ urlencode($notice->title . ' - ' . request()->fullUrl()) }}" 
                   target="_blank"
                   class="w-8 h-8 bg-green-500 hover:bg-green-600 rounded-full flex items-center justify-center text-white text-sm transition">
                    <i class="fab fa-whatsapp"></i>
                </a>
                <button onclick="copyToClipboard('{{ request()->fullUrl() }}')"
                        class="w-8 h-8 bg-gray-500 hover:bg-gray-600 rounded-full flex items-center justify-center text-white text-sm transition">
                    <i class="fas fa-copy"></i>
                </button>
            </div>
        </div>

        <!-- Related Actions -->
        <div class="mt-12 bg-gradient-to-r from-amber-500/20 to-teal-500/20 border border-amber-500/30 rounded-2xl p-8 text-center">
            <h2 class="text-white text-2xl font-bold mb-4">Stay Updated</h2>
            <p class="text-gray-300 mb-6 max-w-2xl mx-auto">
                Don't miss important updates from Padmabati Computer Academy. Join our community to receive notifications.
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

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // Show a temporary success message
        const button = event.target.closest('button');
        const originalIcon = button.innerHTML;
        button.innerHTML = '<i class="fas fa-check"></i>';
        setTimeout(() => {
            button.innerHTML = originalIcon;
        }, 2000);
    });
}
</script>
@endsection