@props(['notice'])

<div class="bg-white/5 border border-white/10 rounded-xl p-6 hover:bg-white/10 transition-all duration-300">
    <div class="flex items-start justify-between mb-3">
        <div class="flex items-center space-x-2">
            <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full
                {{ $notice->priority === 'high' ? 'bg-red-500/20 text-red-400' : 
                   ($notice->priority === 'medium' ? 'bg-yellow-500/20 text-yellow-400' : 'bg-green-500/20 text-green-400') }}">
                {{ ucfirst($notice->priority) }}
            </span>
            <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-blue-500/20 text-blue-400 rounded-full">
                {{ ucfirst($notice->type) }}
            </span>
        </div>
        <time class="text-gray-400 text-sm">
            {{ $notice->publish_at->format('M d, Y') }}
        </time>
    </div>
    
    <h3 class="text-white font-semibold text-lg mb-2 hover:text-amber-400 transition">
        {{ $notice->title }}
    </h3>
    
    <p class="text-gray-400 text-sm mb-4 line-clamp-3">
        {{ $notice->excerpt }}
    </p>
    
    <div class="flex items-center justify-between">
        <span class="text-gray-500 text-xs">
            By {{ $notice->creator->name ?? 'Admin' }}
        </span>
        <a href="{{ route('notices.show', $notice->id) }}" class="text-amber-400 hover:text-amber-300 text-sm font-medium">
            Read More →
        </a>
    </div>
</div>