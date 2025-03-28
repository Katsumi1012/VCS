@extends('layouts.app')

@section('content')
<div class="page-header">
    <h1 class="page-title">Challenge Details</h1>
    <div>
        <a href="{{ route('challenge.student') }}" class="btn btn-light">
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

<div class="grid grid-cols-1 gap-6">
    <div class="card">
        <div class="card-header">
            <h2>Challenge #{{ $chall->cid }}</h2>
        </div>
        <div class="card-body">
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-2">Hint:</h3>
                <p class="text-gray-700">{{ $chall->hint }}</p>
            </div>
            
            <div class="alert alert-info mb-6">
                <div class="alert-content">
                    <p>The answer is the name of a text file without the extension. Enter your answer below.</p>
                </div>
            </div>
            
            <form action="{{ route('challenge.solve') }}" method="POST" class="max-w-md">
                @csrf
                <input type="hidden" name="challenge_id" value="{{ $chall->cid }}">
                
                <div class="form-group">
                    <label for="answer" class="form-label">Your Answer</label>
                    <input type="text" id="answer" name="answer" class="form-control @error('answer') is-invalid @enderror" required>
                    @error('answer')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group mb-0">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-check-circle btn-icon"></i>
                        <span>Submit Answer</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection