<div class="modern-sidebar">
    <div class="sidebar-header">
        <div class="app-logo">
            <img src="{{ asset('images/logo.svg') }}" alt="Logo">
        </div>
    </div>
    
    <div class="sidebar-content">
        <div class="user-info">
            @auth
                <div class="user-avatar">
                    <img src="{{ Auth::user()->avatar ? asset('storage/avatars/' . Auth::user()->avatar) : asset('images/default-avatar.png') }}" alt="User Avatar">
                </div>
                <div class="user-details">
                    <h5 class="user-name">{{ Auth::user()->name }}</h5>
                    <p class="user-role">{{ Auth::user()->roles->first()->name ?? 'User' }}</p>
                </div>
            @endauth
        </div>
        
        <div class="sidebar-menu">
            <ul class="menu-list">
                <li class="menu-item {{ Request::is('home') ? 'active' : '' }}">
                    <a href="{{ route('home') }}" class="menu-link">
                        <i class="menu-icon fas fa-home"></i>
                        <span class="menu-text">Dashboard</span>
                    </a>
                </li>
                
                <li class="menu-divider">
                    <span>Main Menu</span>
                </li>
                
                @role('Teacher')
                <li class="menu-item {{ Request::is('teacher*') ? 'active' : '' }}">
                    <a href="{{ route('teacher.index') }}" class="menu-link">
                        <i class="menu-icon fas fa-chalkboard-teacher"></i>
                        <span class="menu-text">Teachers</span>
                    </a>
                </li>
                
                <li class="menu-item {{ Request::is('student*') ? 'active' : '' }}">
                    <a href="{{ route('student.index') }}" class="menu-link">
                        <i class="menu-icon fas fa-user-graduate"></i>
                        <span class="menu-text">Students</span>
                    </a>
                </li>
                
                <li class="menu-item {{ Request::is('homework*') ? 'active' : '' }} has-submenu">
                    <a href="#" class="menu-link">
                        <i class="menu-icon fas fa-book"></i>
                        <span class="menu-text">Homework</span>
                        <i class="submenu-arrow fas fa-chevron-right"></i>
                    </a>
                    <ul class="submenu-list">
                        <li class="submenu-item">
                            <a href="{{ route('homework.index') }}" class="submenu-link">
                                <span>Homework List</span>
                            </a>
                        </li>
                        <li class="submenu-item">
                            <a href="{{ route('homework.addform') }}" class="submenu-link">
                                <span>Add Homework</span>
                            </a>
                        </li>
                    </ul>
                </li>
                
                <li class="menu-item {{ Request::is('challenge*') ? 'active' : '' }}">
                    <a href="{{ route('challenge.teacher') }}" class="menu-link">
                        <i class="menu-icon fas fa-trophy"></i>
                        <span class="menu-text">Challenges</span>
                    </a>
                </li>
                @endrole
                
                @role('Student')
                <li class="menu-item {{ Request::is('info/ViewTeacher') ? 'active' : '' }}">
                    <a href="{{ route('info.ViewTeacher') }}" class="menu-link">
                        <i class="menu-icon fas fa-chalkboard-teacher"></i>
                        <span class="menu-text">Teachers</span>
                    </a>
                </li>
                
                <li class="menu-item {{ Request::is('info/ViewStudent') ? 'active' : '' }}">
                    <a href="{{ route('info.ViewStudent') }}" class="menu-link">
                        <i class="menu-icon fas fa-user-graduate"></i>
                        <span class="menu-text">Students</span>
                    </a>
                </li>
                
                <li class="menu-item {{ Request::is('studenthomework*') ? 'active' : '' }}">
                    <a href="{{ route('studenthomework.index') }}" class="menu-link">
                        <i class="menu-icon fas fa-book"></i>
                        <span class="menu-text">Homework</span>
                    </a>
                </li>
                
                <li class="menu-item {{ Request::is('challenge/student*') ? 'active' : '' }}">
                    <a href="{{ route('challenge.student') }}" class="menu-link">
                        <i class="menu-icon fas fa-trophy"></i>
                        <span class="menu-text">Challenges</span>
                    </a>
                </li>
                @endrole
                
                <li class="menu-divider">
                    <span>Account</span>
                </li>
                
                <li class="menu-item {{ Request::is('profile*') ? 'active' : '' }}">
                    <a href="{{ route('profile') }}" class="menu-link">
                        <i class="menu-icon fas fa-user-circle"></i>
                        <span class="menu-text">My Profile</span>
                    </a>
                </li>
                
                <li class="menu-item">
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form-sidebar').submit();" class="menu-link">
                        <i class="menu-icon fas fa-sign-out-alt"></i>
                        <span class="menu-text">Logout</span>
                    </a>
                    <form id="logout-form-sidebar" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>
