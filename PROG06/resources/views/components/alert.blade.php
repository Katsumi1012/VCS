<div class="alert alert-{{ $type ?? 'info' }}">
    @if(isset($icon))
    <div class="alert-icon">
        <i class="fas {{ $icon }}"></i>
    </div>
    @endif
    
    <div class="alert-content">
        @if(isset($title))
        <h4 class="alert-title">{{ $title }}</h4>
        @endif
        
        <div>{{ $slot }}</div>
    </div>
    
    @if(isset($dismissible) && $dismissible)
    <button type="button" class="dismiss">
        <i class="fas fa-times"></i>
    </button>
    @endif
</div>
