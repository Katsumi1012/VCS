@extends('layouts.app')

@section('content')
<div class="page-header">
    <h1 class="page-title">Change Password</h1>
    <div>
        <a href="{{ route('profile.index') }}" class="btn btn-light">
            <i class="fas fa-arrow-left btn-icon"></i>
            <span>Back</span>
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('profile.updatePassword') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label for="current_password" class="form-label">Current Password</label>
                <input type="password" id="current_password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" required>
                @error('current_password')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="password" class="form-label">New Password</label>
                <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                @error('password')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
            </div>
            
            <div class="form-group mb-0">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save btn-icon"></i>
                    <span>Update Password</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
