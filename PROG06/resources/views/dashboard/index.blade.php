@extends('layouts.app')

@section('content')
<div class="page-header">
    <h1 class="page-title">Dashboard</h1>
</div>

<div class="dashboard-stats">
    <div class="card">
        <div class="card-body stat-card">
            <div class="stat-value">{{ sprintf("%02d", count($teachers)) }}</div>
            <div class="stat-label">Teachers</div>
        </div>
    </div>
    
    <div class="card">
        <div class="card-body stat-card">
            <div class="stat-value">{{ sprintf("%02d", count($students)) }}</div>
            <div class="stat-label">Students</div>
        </div>
    </div>
    
    @if(isset($homeworkCount))
    <div class="card">
        <div class="card-body stat-card">
            <div class="stat-value">{{ $homeworkCount }}</div>
            <div class="stat-label">Assignments</div>
        </div>
    </div>
    @endif
    
    @if(isset($messageCount))
    <div class="card">
        <div class="card-body stat-card">
            <div class="stat-value">{{ $messageCount }}</div>
            <div class="stat-label">Messages</div>
        </div>
    </div>
    @endif
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="card">
        <div class="card-header">
            <h2>Recent Teachers</h2>
        </div>
        <div class="card-body">
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($teachers->take(5) as $teacher)
                        <tr>
                            <td>{{ $teacher->user->name }}</td>
                            <td>{{ $teacher->user->email }}</td>
                            <td>{{ $teacher->phone }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('teacher.index') }}" class="btn btn-outline-primary">
                View All Teachers
            </a>
        </div>
    </div>
    
    <div class="card">
        <div class="card-header">
            <h2>Recent Students</h2>
        </div>
        <div class="card-body">
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students->take(5) as $student)
                        <tr>
                            <td>{{ $student->user->name }}</td>
                            <td>{{ $student->user->email }}</td>
                            <td>{{ $student->phone }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('student.index') }}" class="btn btn-outline-primary">
                View All Students
            </a>
        </div>
    </div>
</div>
@endsection
