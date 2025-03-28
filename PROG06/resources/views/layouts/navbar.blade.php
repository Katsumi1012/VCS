<nav class="navbar new-navbar">
    <div class="navbar-brand">
        <a href="{{ url('/') }}">{{ config('app.name', 'Laravel') }}</a>
    </div>
    <div class="navbar-menu">
        @auth
            <ul class="navbar-items">
                <li><a href="{{ route('home') }}">Trang chủ</a></li>
                <li><a href="{{ route('profile') }}">Hồ sơ</a></li>
            </ul>
        @endauth
    </div>
</nav>