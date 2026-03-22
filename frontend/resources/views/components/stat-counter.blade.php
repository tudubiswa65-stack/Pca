@props(['value', 'label', 'suffix' => '', 'icon' => ''])

<div x-data="{ 
    count: 0, 
    target: {{ $value }},
    startCounter() {
        const increment = this.target / 100;
        const timer = setInterval(() => {
            this.count += increment;
            if (this.count >= this.target) {
                this.count = this.target;
                clearInterval(timer);
            }
        }, 20);
    }
}" 
x-intersect.once="startCounter()" 
class="text-center">
    @if($icon)
        <div class="w-16 h-16 bg-amber-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="{{ $icon }} text-amber-500 text-2xl"></i>
        </div>
    @endif
    
    <div class="text-4xl font-bold text-white mb-2">
        <span x-text="Math.floor(count)"></span>{{ $suffix }}
    </div>
    
    <div class="text-gray-400 text-sm uppercase tracking-wider">
        {{ $label }}
    </div>
</div>