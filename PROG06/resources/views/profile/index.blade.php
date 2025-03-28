@extends('layouts.app')

@section('content')
<div class="page-header">
    <h1 class="page-title">My Profile</h1>
    <div>
        <a href="{{ route('profile.edit') }}" class="btn btn-primary">
            <i class="fas fa-edit btn-icon"></i>
            <span>Edit Profile</span>
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-1">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h2 class="text-lg font-semibold">Personal Information</h2>
            </div>
            <div class="card-body profile-card">
                <div class="profile-image">
                    @if(auth()->user()->profile_picture !== 'avatar.png')
                        <img src="{{ asset('images/profile/' . auth()->user()->profile_picture) }}" alt="{{ auth()->user()->name }}">
                    @else
                        {{ substr(auth()->user()->name, 0, 1) }}
                    @endif
                </div>
                <h2 class="profile-name">{{ auth()->user()->name }}</h2>
                <p class="profile-role">
                    <span class="badge badge-primary">
                        {{ auth()->user()->roles->first()->name ?? 'User' }}
                    </span>
                </p>
                
                <div class="profile-info mt-4">
                    <div class="profile-info-item flex items-center p-3 border-b border-gray-100">
                        <div class="flex-shrink-0 w-10 text-center">
                            <i class="fas fa-envelope text-primary"></i>
                        </div>
                        <div class="ml-3 flex-grow">
                            <span class="text-sm text-gray-500">Email</span>
                            <p class="font-medium">{{ auth()->user()->email }}</p>
                        </div>
                    </div>
                    
                    @if(auth()->user()->roles->first()->name == 'Student' && auth()->user()->student)
                        <div class="profile-info-item flex items-center p-3 border-b border-gray-100">
                            <div class="flex-shrink-0 w-10 text-center">
                                <i class="fas fa-phone text-primary"></i>
                            </div>
                            <div class="ml-3 flex-grow">
                                <span class="text-sm text-gray-500">Phone</span>
                                <p class="font-medium">{{ auth()->user()->student->phone ?: 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="profile-info-item flex items-center p-3 border-b border-gray-100">
                            <div class="flex-shrink-0 w-10 text-center">
                                <i class="fas fa-venus-mars text-primary"></i>
                            </div>
                            <div class="ml-3 flex-grow">
                                <span class="text-sm text-gray-500">Gender</span>
                                <p class="font-medium">{{ ucfirst(auth()->user()->student->gender) }}</p>
                            </div>
                        </div>
                    @endif
                    
                    @if(auth()->user()->roles->first()->name == 'Teacher' && auth()->user()->teacher)
                        <div class="profile-info-item flex items-center p-3 border-b border-gray-100">
                            <div class="flex-shrink-0 w-10 text-center">
                                <i class="fas fa-phone text-primary"></i>
                            </div>
                            <div class="ml-3 flex-grow">
                                <span class="text-sm text-gray-500">Phone</span>
                                <p class="font-medium">{{ auth()->user()->teacher->phone ?: 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="profile-info-item flex items-center p-3 border-b border-gray-100">
                            <div class="flex-shrink-0 w-10 text-center">
                                <i class="fas fa-book text-primary"></i>
                            </div>
                            <div class="ml-3 flex-grow">
                                <span class="text-sm text-gray-500">Subject</span>
                                <p class="font-medium">{{ auth()->user()->teacher->subject ?: 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="profile-info-item flex items-center p-3 border-b border-gray-100">
                            <div class="flex-shrink-0 w-10 text-center">
                                <i class="fas fa-venus-mars text-primary"></i>
                            </div>
                            <div class="ml-3 flex-grow">
                                <span class="text-sm text-gray-500">Gender</span>
                                <p class="font-medium">{{ ucfirst(auth()->user()->teacher->gender) }}</p>
                            </div>
                        </div>
                    @endif
                    
                    <div class="profile-info-item flex items-center p-3">
                        <div class="flex-shrink-0 w-10 text-center">
                            <i class="fas fa-calendar-alt text-primary"></i>
                        </div>
                        <div class="ml-3 flex-grow">
                            <span class="text-sm text-gray-500">Joined</span>
                            <p class="font-medium">{{ auth()->user()->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card mt-6">
            <div class="card-header bg-gray-700 text-white">
                <h2 class="text-lg font-semibold">Account Security</h2>
            </div>
            <div class="card-body p-4">
                <a href="{{ route('profile.changePassword') }}" class="btn btn-outline-primary w-full">
                    <i class="fas fa-lock btn-icon"></i>
                    <span>Change Password</span>
                </a>
            </div>
        </div>
    </div>
    
    <div class="lg:col-span-2">
        <div class="grid grid-cols-1 gap-6">
            <div class="card">
                <div class="card-header">
                    <h2>Recent Messages</h2>
                </div>
                <div class="card-body">
                    @if(isset($recent_messages) && count($recent_messages) > 0)
                        <div class="table-container">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Sender</th>
                                        <th>Message</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recent_messages as $message)
                                        <tr>
                                            <td>{{ $message->sender_name }}</td>
                                            <td>{{ \Illuminate\Support\Str::limit($message->msg, 50) }}</td>
                                            <td>
                                                @if($message->created_at instanceof \Carbon\Carbon)
                                                    {{ $message->created_at->format('M d, Y') }}
                                                @else
                                                    {{ \Carbon\Carbon::parse($message->created_at)->format('M d, Y') }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <div class="alert-content">
                                <p>No recent messages found.</p>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="card-footer">
                    <a href="{{ route('message.index', auth()->user()->id) }}" class="btn btn-outline-primary">
                        View All Messages
                    </a>
                </div>
            </div>
            
            @role('Student')
            <div class="card">
                <div class="card-header">
                    <h2>My Homework Submissions</h2>
                </div>
                <div class="card-body">
                    @if(isset($recent_submissions) && count($recent_submissions) > 0)
                        <div class="table-container">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Homework</th>
                                        <th>Submitted On</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recent_submissions as $submission)
                                        <tr>
                                            <td>{{ $submission->homework->filename ?? 'Unknown' }}</td>
                                            <td>
                                                @if($submission->created_at instanceof \Carbon\Carbon)
                                                    {{ $submission->created_at->format('M d, Y') }}
                                                @else
                                                    {{ \Carbon\Carbon::parse($submission->created_at)->format('M d, Y') }}
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge badge-{{ isset($submission->status) ? ($submission->status == 'approved' ? 'success' : ($submission->status == 'pending' ? 'warning' : 'danger')) : 'warning' }}">
                                                    {{ ucfirst($submission->status ?? 'Pending') }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <div class="alert-content">
                                <p>No homework submissions found.</p>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="card-footer">
                    <a href="{{ route('homework.studentindex') }}" class="btn btn-outline-primary">
                        View All Homework
                    </a>
                </div>
            </div>
            @endrole
            
            @role('Teacher')
            <div class="card">
                <div class="card-header">
                    <h2>My Assigned Homework</h2>
                </div>
                <div class="card-body">
                    @if(isset($recent_homework) && count($recent_homework) > 0)
                        <div class="table-container">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Filename</th>
                                        <th>Date Added</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recent_homework as $task)
                                        <tr>
                                            <td>{{ $task->task_id }}</td>
                                            <td>
                                                <a href="{{ route('homework.download', $task->filename) }}" class="text-primary hover:underline">
                                                    {{ $task->filename }}
                                                </a>
                                            </td>
                                            <td>
                                                @if($task->created_at instanceof \Carbon\Carbon)
                                                    {{ $task->created_at->format('M d, Y') }}
                                                @else
                                                    {{ date('M d, Y', strtotime($task->created_at)) }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <div class="alert-content">
                                <p>No assigned homework found.</p>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="card-footer">
                    <a href="{{ route('homework.index') }}" class="btn btn-outline-primary">
                        View All Homework
                    </a>
                </div>
            </div>
            @endrole
        </div>
    </div>
</div>
@endsection