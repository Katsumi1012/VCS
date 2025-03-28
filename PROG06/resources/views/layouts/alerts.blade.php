@if (session('success'))
    <div class="alert alert-success alert-modern">
        <div class="alert-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="alert-content">
            <div class="alert-title">Success</div>
            <div class="alert-message">{{ session('success') }}</div>
        </div>
        <button class="alert-close">
            <i class="fas fa-times"></i>
        </button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-modern">
        <div class="alert-icon">
            <i class="fas fa-exclamation-circle"></i>
        </div>
        <div class="alert-content">
            <div class="alert-title">Error</div>
            <div class="alert-message">{{ session('error') }}</div>
        </div>
        <button class="alert-close">
            <i class="fas fa-times"></i>
        </button>
    </div>
@endif

@if (session('warning'))
    <div class="alert alert-warning alert-modern">
        <div class="alert-icon">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <div class="alert-content">
            <div class="alert-title">Warning</div>
            <div class="alert-message">{{ session('warning') }}</div>
        </div>
        <button class="alert-close">
            <i class="fas fa-times"></i>
        </button>
    </div>
@endif

@if (session('info'))
    <div class="alert alert-info alert-modern">
        <div class="alert-icon">
            <i class="fas fa-info-circle"></i>
        </div>
        <div class="alert-content">
            <div class="alert-title">Information</div>
            <div class="alert-message">{{ session('info') }}</div>
        </div>
        <button class="alert-close">
            <i class="fas fa-times"></i>
        </button>
    </div>
@endif
