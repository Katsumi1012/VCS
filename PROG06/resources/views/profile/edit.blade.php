@extends('layouts.app')

@section('content')
<div class="page-header">
    <h1 class="page-title">Edit Profile</h1>
    <div>
        <a href="{{ route('profile.index') }}" class="btn btn-light">
            <i class="fas fa-arrow-left btn-icon"></i>
            <span>Back</span>
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @csrf
            
            <div class="md:col-span-2">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="form-group">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', auth()->user()->name) }}" required>
                        @error('name')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', auth()->user()->email) }}" required>
                        @error('email')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" id="phone" name="phone" class="form-control @error('phone') is-invalid @enderror" 
                            value="{{ old('phone', 
                                auth()->user()->hasRole('Student') && auth()->user()->student ? auth()->user()->student->phone : 
                                (auth()->user()->hasRole('Teacher') && auth()->user()->teacher ? auth()->user()->teacher->phone : '')) 
                            }}">
                        @error('phone')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    @if(auth()->user()->hasRole('Teacher') && auth()->user()->teacher)
                    <div class="form-group">
                        <label for="subject" class="form-label">Subject</label>
                        <input type="text" id="subject" name="subject" class="form-control @error('subject') is-invalid @enderror" value="{{ old('subject', auth()->user()->teacher->subject) }}">
                        @error('subject')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                    @endif
                </div>
                
                <div class="form-group">
                    <label for="profile_picture" class="form-label">Profile Picture</label>
                    <input type="file" id="profile_picture" name="profile_picture" class="form-control @error('profile_picture') is-invalid @enderror">
                    @error('profile_picture')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group mt-6">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save btn-icon"></i>
                        <span>Update Profile</span>
                    </button>
                </div>
            </div>
            
            <div class="md:col-span-1 order-first md:order-last mb-6 md:mb-0">
                <div class="flex justify-center">
                    <div class="profile-image w-32 h-32">
                        @if(auth()->user()->profile_picture !== 'avatar.png')
                            <img src="{{ asset('images/profile/' . auth()->user()->profile_picture) }}" alt="{{ auth()->user()->name }}" class="w-full h-full object-cover">
                        @else
                            {{ substr(auth()->user()->name, 0, 1) }}
                        @endif
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        styleFileInputs();
    });
</script>
@endpush