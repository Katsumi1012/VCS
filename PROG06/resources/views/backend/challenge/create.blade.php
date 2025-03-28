@extends('layouts.app')

@section('content')
<div class="page-header">
    <h1 class="page-title">Create Challenge</h1>
    <div>
        <a href="{{ route('challenge.teacher') }}" class="btn btn-light">
            <i class="fas fa-arrow-left btn-icon"></i>
            <span>Back</span>
        </a>
    </div>
</div>

@if(session('error'))
<div class="alert alert-danger">
    <div class="alert-content">
        <p>{{ session('error') }}</p>
    </div>
</div>
@endif

@if(session('success'))
<div class="alert alert-success">
    <div class="alert-content">
        <p>{{ session('success') }}</p>
    </div>
</div>
@endif

<div class="card">
    <div class="card-header">
        <h2>Upload Challenge Content</h2>
    </div>
    <div class="card-body">
        <form action="{{ route('challenge.create') }}" method="POST" class="w-full max-w-xl" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group">
                <label for="hint" class="form-label">Challenge Hint</label>
                <input id="hint" name="hint" class="form-control @error('hint') is-invalid @enderror" type="text" value="{{ old('hint') }}" required>
                @error('hint')
                    <div class="form-error">{{ $message }}</div>
                @enderror
                <div class="mt-2 text-sm text-gray-500">
                    Provide a hint for students to help solve this challenge
                </div>
            </div>
            
            <div class="form-group">
                <label for="challengefile" class="form-label">Upload Text File</label>
                <input id="challengefile" name="challengefile" class="form-control @error('challengefile') is-invalid @enderror" type="file" required>
                @error('challengefile')
                    <div class="form-error">{{ $message }}</div>
                @enderror
                <div class="mt-2 text-sm text-gray-500">
                    <p>Upload a TXT file containing a poem, story, or other text content.</p>
                    <p><strong>Important:</strong> The filename should contain only letters, numbers, and spaces (no accents or special characters).</p>
                    <p><strong>Example:</strong> "bai tho mua thu.txt", "van ban mau.txt"</p>
                    <p class="mt-1 font-semibold">The filename (without extension) will be the answer to the challenge.</p>
                </div>
            </div>
            
            <div class="form-group mb-0">
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-plus btn-icon"></i>
                    <span>Create Challenge</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection