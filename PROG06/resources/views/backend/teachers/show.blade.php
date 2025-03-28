@extends('layouts.app')

@section('content')
<div class="page-header">
    <h1 class="page-title">Teacher Profile</h1>
    <div>
        <a href="{{ route('teacher.index') }}" class="btn btn-light">
            <i class="fas fa-arrow-left btn-icon"></i>
            <span>Back</span>
        </a>
        <a href="{{ route('teacher.edit', $teacher->id) }}" class="btn btn-primary ml-2">
            <i class="fas fa-edit btn-icon"></i>
            <span>Edit</span>
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-1">
        <div class="card">
            <div class="card-body profile-card">
                <div class="profile-image">
                    @if($teacher->user->profile_picture !== 'avatar.png')
                        <img src="{{ asset('images/profile/' . $teacher->user->profile_picture) }}" alt="{{ $teacher->user->name }}">
                    @else
                        {{ substr($teacher->user->name, 0, 1) }}
                    @endif
                </div>
                <h2 class="profile-name">{{ $teacher->user->name }}</h2>
                <p class="profile-role">Teacher</p>
                
                <div class="profile-info">
                    <div class="profile-info-item">
                        <span class="profile-info-label">Email</span>
                        <span class="profile-info-value">{{ $teacher->user->email }}</span>
                    </div>
                    <div class="profile-info-item">
                        <span class="profile-info-label">Phone</span>
                        <span class="profile-info-value">{{ $teacher->phone ?: 'N/A' }}</span>
                    </div>
                    <div class="profile-info-item">
                        <span class="profile-info-label">Subject</span>
                        <span class="profile-info-value">{{ $teacher->subject ?: 'N/A' }}</span>
                    </div>
                    <div class="profile-info-item">
                        <span class="profile-info-label">Gender</span>
                        <span class="profile-info-value">{{ ucfirst($teacher->gender) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="lg:col-span-2">
        <div class="grid grid-cols-1 gap-6">
            <div class="card">
                <div class="card-header">
                    <h2>Teacher Information</h2>
                </div>
                <div class="card-body">
                    <div class="profile-info">
                        <div class="profile-info-item">
                            <span class="profile-info-label">Teacher ID</span>
                            <span class="profile-info-value">TCH-{{ str_pad($teacher->id, 4, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <div class="profile-info-item">
                            <span class="profile-info-label">Joined Date</span>
                            <span class="profile-info-value">{{ $teacher->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h2>Assigned Homework</h2>
                </div>
                <div class="card-body">
                    @if(isset($homework) && count($homework) > 0)
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
                                    @foreach($homework as $task)
                                        <tr>
                                            <td>{{ $task->task_id }}</td>
                                            <td>
                                                <a href="{{ route('homework.download', $task->filename) }}" class="text-primary hover:underline">
                                                    {{ $task->filename }}
                                                </a>
                                            </td>
                                            <td>{{ date('M d, Y', strtotime($task->created_at)) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <div class="alert-content">
                                <p>No homework assignments found.</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h2>Send Message</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('message.send') }}" method="POST" class="message-form">
                        @csrf
                        <input type="hidden" name="receiver_id" value="{{ $teacher->user->id }}">
                        
                        <div class="form-group">
                            <label for="message" class="form-label">Message</label>
                            <textarea id="message" name="msg" rows="3" class="form-control @error('msg') is-invalid @enderror" required></textarea>
                            @error('msg')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-primary message-send">
                                <i class="fas fa-paper-plane btn-icon"></i>
                                <span>Send Message</span>
                            </button>
                        </div>
                        
                        <div class="message-status" style="display: none;"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection