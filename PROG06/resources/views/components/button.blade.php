<button 
    type="{{ $type ?? 'button' }}" 
    class="btn btn-{{ $variant ?? 'primary' }} {{ $size ?? '' }} {{ $class ?? '' }}"
    {{ $attributes }}
>
    @if(isset($icon))
    <i class="fas {{ $icon }} btn-icon"></i>
    @endif
    
    <span>{{ $slot }}</span>
</button>
