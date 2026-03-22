@props(['rating', 'maxStars' => 5, 'size' => 'text-base', 'color' => 'text-amber-400'])

<div class="flex items-center space-x-1">
    @for($i = 1; $i <= $maxStars; $i++)
        @if($i <= $rating)
            <i class="fas fa-star {{ $color }} {{ $size }}"></i>
        @elseif($i - 0.5 <= $rating)
            <i class="fas fa-star-half-alt {{ $color }} {{ $size }}"></i>
        @else
            <i class="far fa-star text-gray-400 {{ $size }}"></i>
        @endif
    @endfor
</div>