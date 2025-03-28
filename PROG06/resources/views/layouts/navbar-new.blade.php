<nav class="modern-navbar">
    <div class="navbar-container">
        <div class="navbar-left">
            <button id="sidebar-toggle" class="sidebar-toggle-btn">
                <i class="fas fa-bars"></i>
            </button>
            <div class="navbar-brand">
                <a href="{{ url('/home') }}">
                    <span class="brand-text">{{ config('app.name', 'Laravel') }}</span>
                </a>
            </div>
        </div>
        
        <div class="navbar-center">
            <div class="search-container">
                <input type="text" class="search-input" placeholder="Search...">
                <button class="search-btn">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
        
        <div class="navbar-right">
            <div class="navbar-items">
                <div class="navbar-item">
                    <button class="notification-btn">
                        <i class="fas fa-bell"></i>
                        <span class="badge">3</span>
                    </button>
                    <div class="dropdown-menu notifications-menu">
                        <div class="dropdown-header">Notifications</div>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-envelope mr-2"></i> New message
                            <span class="float-right text-muted text-sm">3 mins</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                    </div>
                </div>
                
                <div class="navbar-item user-menu">
                    @auth
                        <div class="dropdown">
                            <button class="user-dropdown-btn">
                                <div class="avatar">
                                    <img src="{{ Auth::user()->avatar ? asset('storage/avatars/' . Auth::user()->avatar) : asset('images/default-avatar.png') }}" alt="User Avatar">
                                </div>
                                <span class="user-name">{{ Auth::user()->name }}</span>
                                <i class="fas fa-chevron-down"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('profile') }}">
                                    <i class="fas fa-user mr-2"></i> My Profile
                                </a>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="fas fa-cog mr-2"></i> Settings
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</nav>
