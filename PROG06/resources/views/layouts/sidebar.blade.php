<aside class="sidebar">
    <div class="sidebar-header">
        <a href="{{ route('home') }}" class="logo">
            <div class="logo-icon">LMS</div>
            <span>Student Manager</span>
        </a>
    </div>
    
    <div class="sidebar-content">
        @role('Admin')
        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('home') }}">
                    <span class="menu-icon"><i class="fas fa-home"></i></span>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('teacher.index') }}">
                    <span class="menu-icon"><i class="fas fa-chalkboard-teacher"></i></span>
                    <span>Teachers</span>
                </a>
            </li>
            <li>
                <a href="{{ route('student.index') }}">
                    <span class="menu-icon"><i class="fas fa-user-graduate"></i></span>
                    <span>Students</span>
                </a>
            </li>
            <li>
                <a href="{{ route('message.index', auth()->user()->id ) }}">
                    <span class="menu-icon"><i class="fas fa-envelope"></i></span>
                    <span>Messages</span>
                </a>
            </li>
            <li>
                <a href="{{ route('homework.index') }}">
                    <span class="menu-icon"><i class="fas fa-book-open"></i></span>
                    <span>Homework</span>
                </a>
            </li>
            <li>
                <a href="{{ route('challenge.teacher') }}">
                    <span class="menu-icon"><i class="fas fa-trophy"></i></span>
                    <span>Challenges</span>
                </a>
            </li>
        </ul>
        @endrole
        
        @role('Teacher')
        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('home') }}">
                    <span class="menu-icon"><i class="fas fa-home"></i></span>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('student.index') }}">
                    <span class="menu-icon"><i class="fas fa-user-graduate"></i></span>
                    <span>Students</span>
                </a>
            </li>
            <li>
                <a href="{{ route('message.index', auth()->user()->id ) }}">
                    <span class="menu-icon"><i class="fas fa-envelope"></i></span>
                    <span>Messages</span>
                </a>
            </li>
            <li>
                <a href="{{ route('homework.index') }}">
                    <span class="menu-icon"><i class="fas fa-book-open"></i></span>
                    <span>Homework</span>
                </a>
            </li>
            <li>
                <a href="{{ route('challenge.teacher') }}">
                    <span class="menu-icon"><i class="fas fa-trophy"></i></span>
                    <span>Challenges</span>
                </a>
            </li>
        </ul>
        @endrole
        
        @role('Student')
        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('home') }}">
                    <span class="menu-icon"><i class="fas fa-home"></i></span>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('info.ViewTeacher') }}">
                    <span class="menu-icon"><i class="fas fa-chalkboard-teacher"></i></span>
                    <span>Teachers</span>
                </a>
            </li>
            <li>
                <a href="{{ route('info.ViewStudent') }}">
                    <span class="menu-icon"><i class="fas fa-user-graduate"></i></span>
                    <span>Students</span>
                </a>
            </li>
            <li>
                <a href="{{ route('message.index',auth()->user()->id ) }}">
                    <span class="menu-icon"><i class="fas fa-envelope"></i></span>
                    <span>Messages</span>
                </a>
            </li>
            <li>
                <a href="{{ route('homework.studentindex') }}">
                    <span class="menu-icon"><i class="fas fa-book-open"></i></span>
                    <span>Homework</span>
                </a>
            </li>
            <li>
                <a href="{{ route('challenge.student') }}">
                    <span class="menu-icon"><i class="fas fa-trophy"></i></span>
                    <span>Challenges</span>
                </a>
            </li>
        </ul>
        @endrole
    </div>
</aside>