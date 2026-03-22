@props(['gallery'])

<div x-data="{ modalOpen: false }" class="group cursor-pointer">
    <!-- Thumbnail -->
    <div @click="modalOpen = true" class="relative overflow-hidden rounded-xl bg-white/5 hover:bg-white/10 transition-all duration-300">
        <img src="{{ $gallery->image_url }}" alt="{{ $gallery->title }}" 
             class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-300">
        
        <!-- Overlay -->
        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
            <div class="absolute bottom-0 left-0 right-0 p-4">
                <h3 class="text-white font-semibold text-sm mb-1">{{ $gallery->title }}</h3>
                @if($gallery->description)
                    <p class="text-gray-300 text-xs line-clamp-2">{{ $gallery->description }}</p>
                @endif
            </div>
        </div>
        
        <!-- View Icon -->
        <div class="absolute top-4 right-4 w-8 h-8 bg-black/50 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
            <i class="fas fa-expand-alt text-white text-sm"></i>
        </div>
    </div>
    
    <!-- Modal -->
    <div x-show="modalOpen" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-black/90" @click.away="modalOpen = false">
        <div class="relative max-w-4xl max-h-[90vh] mx-4">
            <img src="{{ $gallery->image_url }}" alt="{{ $gallery->title }}" 
                 class="max-w-full max-h-full object-contain rounded-lg">
            
            <!-- Close button -->
            <button @click="modalOpen = false" 
                    class="absolute -top-4 -right-4 w-8 h-8 bg-white rounded-full flex items-center justify-center text-gray-800 hover:bg-gray-100 transition">
                <i class="fas fa-times text-sm"></i>
            </button>
            
            <!-- Image info -->
            @if($gallery->title || $gallery->description)
                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-6 rounded-b-lg">
                    <h3 class="text-white font-semibold text-lg mb-1">{{ $gallery->title }}</h3>
                    @if($gallery->description)
                        <p class="text-gray-300 text-sm">{{ $gallery->description }}</p>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>