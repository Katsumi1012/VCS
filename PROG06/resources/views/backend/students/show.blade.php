@extends('layouts.app')

@section('content')
<div class="page-header">
    <h1 class="page-title">Student Profile</h1>
    <div>
        <a href="{{ route('student.index') }}" class="btn btn-light">
            <i class="fas fa-arrow-left btn-icon"></i>
            <span>Back</span>
        </a>
        <a href="{{ route('student.edit', $student->id) }}" class="btn btn-primary ml-2">
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
                    @if($student->user->profile_picture !== 'avatar.png')
                        <img src="{{ asset('images/profile/' . $student->user->profile_picture) }}" alt="{{ $student->user->name }}">
                    @else
                        {{ substr($student->user->name, 0, 1) }}
                    @endif
                </div>
                <h2 class="profile-name">{{ $student->user->name }}</h2>
                <p class="profile-role">Student</p>
                
                <div class="profile-info">
                    <div class="profile-info-item">
                        <span class="profile-info-label">Email</span>
                        <span class="profile-info-value">{{ $student->user->email }}</span>
                    </div>
                    <div class="profile-info-item">
                        <span class="profile-info-label">Phone</span>
                        <span class="profile-info-value">{{ $student->phone ?: 'N/A' }}</span>
                    </div>
                    <div class="profile-info-item">
                        <span class="profile-info-label">Gender</span>
                        <span class="profile-info-value">{{ ucfirst($student->gender) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="lg:col-span-2">
        <div class="grid grid-cols-1 gap-6">
            <div class="card">
                <div class="card-header">
                    <h2>Academic Information</h2>
                </div>
                <div class="card-body">
                    <div class="profile-info">
                        <div class="profile-info-item">
                            <span class="profile-info-label">Student ID</span>
                            <span class="profile-info-value">STU-{{ str_pad($student->id, 4, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <div class="profile-info-item">
                            <span class="profile-info-label">Joined Date</span>
                            <span class="profile-info-value">{{ $student->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h2>Homework Submissions</h2>
                </div>
                <div class="card-body">
                    @if(isset($homework_solutions) && count($homework_solutions) > 0)
                        <div class="table-container">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Homework</th>
                                        <th>Submitted</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($homework_solutions as $solution)
                                        <tr>
                                            <td>{{ $solution->homework->filename ?? 'Unknown' }}</td>
                                            <td>{{ $solution->created_at->format('M d, Y') }}</td>
                                            <td>
                                                <span class="badge badge-{{ $solution->status == 'approved' ? 'success' : ($solution->status == 'pending' ? 'warning' : 'danger') }}">
                                                    {{ ucfirst($solution->status ?? 'Pending') }}
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
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h2>Send Message</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('message.send') }}" method="POST" class="message-form">
                        @csrf
                        <input type="hidden" name="receiver_id" value="{{ $student->user->id }}">
                        
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