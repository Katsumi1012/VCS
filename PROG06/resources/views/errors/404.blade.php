<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 Not Found - {{ config('app.name', 'Laravel') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/modern-theme.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        .error-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: var(--spacing-6);
        }
        
        .error-code {
            font-size: 8rem;
            font-weight: 700;
            color: var(--primary);
            line-height: 1;
            margin-bottom: var(--spacing-4);
        }
        
        .error-title {
            font-size: 2rem;
            font-weight: 600;
            color: var(--gray-800);
            margin-bottom: var(--spacing-4);
        }
        
        .error-message {
            font-size: 1.125rem;
            color: var(--gray-600);
            max-width: 500px;
            margin: 0 auto var(--spacing-6);
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div>
            <div class="error-code">404</div>
            <h1 class="error-title">Page Not Found</h1>
            <p class="error-message">Sorry, the page you are looking for might have been removed or is temporarily unavailable.</p>
            <a href="{{ route('home') }}" class="btn btn-primary">
                <i class="fas fa-home btn-icon"></i>
                <span>Back to Home</span>
            </a>
        </div>
    </div>
</body>
</html>