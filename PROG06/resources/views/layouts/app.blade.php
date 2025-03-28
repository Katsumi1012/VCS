<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/modern-theme.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    @stack('scripts')
</head>
<body>
    <div class="app-container">
        @include('layouts.sidebar')
        
        <div class="main-content" id="main-content">
            @include('layouts.header')
            
            <div class="page-container">
                @yield('content')
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile menu toggle
            const menuToggle = document.querySelector('.menu-toggle');
            const sidebar = document.querySelector('.sidebar');
            
            if (menuToggle) {
                menuToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                });
            }

            // Profile dropdown toggle
            const profileButton = document.querySelector('.profile-button');
            const profileMenu = document.querySelector('.profile-menu');
            
            if (profileButton && profileMenu) {
                profileButton.addEventListener('click', function() {
                    profileMenu.classList.toggle('show');
                });
                
                // Close the dropdown when clicking outside
                document.addEventListener('click', function(event) {
                    if (!profileButton.contains(event.target) && !profileMenu.contains(event.target)) {
                        profileMenu.classList.remove('show');
                    }
                });
            }

            // Add active class to current menu item
            const currentPath = window.location.pathname;
            const menuLinks = document.querySelectorAll('.sidebar-menu a');
            
            menuLinks.forEach(link => {
                const href = link.getAttribute('href');
                if (href === currentPath || currentPath.startsWith(href) && href !== '/') {
                    link.classList.add('active');
                }
            });
        });
    </script>
</body>
</html>