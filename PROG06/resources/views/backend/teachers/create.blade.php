@extends('layouts.app')

@section('content')
<div class="page-header">
    <h1 class="page-title">Add Teacher</h1>
    <div>
        <a href="{{ route('teacher.index') }}" class="btn btn-light">
            <i class="fas fa-arrow-left btn-icon"></i>
            <span>Back</span>
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('teacher.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="form-group">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                    @error('password')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" id="phone" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}">
                    @error('phone')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="subject" class="form-label">Subject</label>
                    <input type="text" id="subject" name="subject" class="form-control @error('subject') is-invalid @enderror" value="{{ old('subject') }}">
                    @error('subject')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label class="form-label">Gender</label>
                    <div class="form-radio-group">
                        <label class="form-radio-label">
                            <input type="radio" name="gender" value="male" class="form-radio" {{ old('gender') == 'male' ? 'checked' : '' }}>
                            <span>Male</span>
                        </label>
                        <label class="form-radio-label">
                            <input type="radio" name="gender" value="female" class="form-radio" {{ old('gender') == 'female' ? 'checked' : '' }}>
                            <span>Female</span>
                        </label>
                        <label class="form-radio-label">
                            <input type="radio" name="gender" value="other" class="form-radio" {{ old('gender') == 'other' ? 'checked' : '' }}>
                            <span>Other</span>
                        </label>
                    </div>
                    @error('gender')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group col-span-2">
                    <label for="profile_picture" class="form-label">Profile Picture</label>
                    <input type="file" id="profile_picture" name="profile_picture" class="form-control @error('profile_picture') is-invalid @enderror">
                    @error('profile_picture')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="form-group mt-6">
                <button type="submit" class="btn btn-primary">
                    Add Teacher
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(function() {
        // Initialize any plugins or custom scripts
        styleFileInputs();
    });
</script>
@endpush