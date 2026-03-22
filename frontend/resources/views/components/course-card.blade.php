@props(['course'])

<div class="bg-white/5 border border-white/10 rounded-2xl p-6 hover:bg-white/10 hover:border-amber-500/30 transition-all duration-300 group">
    <div class="text-4xl mb-4">{{ $course->icon ?? '💻' }}</div>
    <h3 class="text-white font-bold text-lg mb-2 group-hover:text-amber-400 transition">{{ $course->name }}</h3>
    <p class="text-gray-400 text-sm mb-4 line-clamp-2">{{ $course->description }}</p>
    
    <div class="flex items-center justify-between mb-4">
        <span class="text-amber-400 font-semibold">₹{{ number_format($course->fee) }}</span>
        <span class="text-gray-400 text-sm">{{ $course->duration_months }} months</span>
    </div>
    
    <div class="mb-4">
        <span class="inline-block bg-teal-500/20 text-teal-400 text-xs px-2 py-1 rounded-full">{{ ucfirst($course->category) }}</span>
    </div>
    
    <a href="{{ route('courses.show', $course->slug) }}" class="block w-full bg-amber-500 hover:bg-amber-600 text-white text-center py-2 rounded-lg font-medium transition">
        View Course
    </a>
</div>