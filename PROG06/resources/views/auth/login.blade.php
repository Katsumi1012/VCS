<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/modern-theme.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: var(--spacing-6);
            background: linear-gradient(135deg, var(--primary-light) 0%, var(--primary) 100%);
        }
        
        .auth-card {
            width: 100%;
            max-width: 400px;
        }
        
        .auth-logo {
            text-align: center;
            margin-bottom: var(--spacing-8);
        }
        
        .auth-logo-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 60px;
            height: 60px;
            background-color: var(--primary);
            color: var(--white);
            font-size: 1.5rem;
            font-weight: 700;
            border-radius: var(--rounded-lg);
            margin-bottom: var(--spacing-4);
        }
        
        .auth-title {
            font-size: 1.5rem;
            font-weight: 600;
            text-align: center;
            margin-bottom: var(--spacing-6);
            color: var(--gray-800);
        }
    </style>
</head>
<body class="bg-gradient-to-r from-primary-light to-primary">
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-logo">
                <div class="auth-logo-icon">LMS</div>
                <h1 class="text-xl font-bold text-gray-800">Student Manager</h1>
            </div>
            
            <div class="card">
                <div class="card-body">
                    <h2 class="auth-title">Sign In</h2>
                    
                    @if (session('error'))
                        <div class="alert alert-danger mb-4">
                            <div class="alert-content">
                                {{ session('error') }}
                            </div>
                        </div>
                    @endif
                    
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        
                        <div class="form-group">
                            <label for="email" class="form-label">Email Address</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                <input id="email" type="email" class="form-control pl-10 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            </div>
                            @error('email')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <div class="flex justify-between mb-2">
                                <label for="password" class="form-label">Password</label>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="text-sm text-primary hover:underline">
                                        Forgot Password?
                                    </a>
                                @endif
                            </div>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input id="password" type="password" class="form-control pl-10 @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                            </div>
                            @error('password')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-checkbox-label">
                                <input type="checkbox" name="remember" id="remember" class="form-checkbox" {{ old('remember') ? 'checked' : '' }}>
                                <span>Remember Me</span>
                            </label>
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary w-full">
                                Sign In
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
