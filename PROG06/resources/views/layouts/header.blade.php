<header class="header">
    <div class="header-left">
        <button class="menu-toggle">
            <i class="fas fa-bars"></i>
        </button>
        <h1 class="header-title">{{ ucfirst(request()->segment(1) ?? 'Dashboard') }}</h1>
    </div>
    
    <div class="header-right">
        <div class="profile-dropdown">
            <button class="profile-button" id="profileDropdown">
                <div class="profile-avatar">
                    @if(auth()->user()->profile_picture !== 'avatar.png')
                        <img src="{{ asset('images/profile/' . auth()->user()->profile_picture) }}" alt="Avatar">
                    @else
                        {{ substr(auth()->user()->name, 0, 1) }}
                    @endif
                </div>
                <div class="profile-info">
                    <span class="profile-name">{{ auth()->user()->name }}</span>
                    <span class="profile-role">{{ auth()->user()->roles->first()->name ?? 'User' }}</span>
                </div>
                <i class="fas fa-chevron-down ml-2 text-sm"></i>
            </button>
            
            <div class="profile-menu" id="profileMenu">
                <a href="{{ route('profile.index') }}" class="profile-menu-item">
                    <i class="fas fa-user"></i>
                    <span>Profile</span>
                </a>
                <a href="{{ route('profile.edit') }}" class="profile-menu-item">
                    <i class="fas fa-edit"></i>
                    <span>Edit Profile</span>
                </a>
                <div class="profile-menu-divider"></div>
                <a href="{{ route('logout') }}" class="profile-menu-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Log Out</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</header>
