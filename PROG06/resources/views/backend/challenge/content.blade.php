@extends('layouts.app')

@section('content')
<div class="page-header">
    <h1 class="page-title">Challenge Result</h1>
    <div>
        <a href="{{ route('challenge.student') }}" class="btn btn-light">
            <i class="fas fa-arrow-left btn-icon"></i>
            <span>Back to Challenges</span>
        </a>
    </div>
</div>

<div class="grid grid-cols-1 gap-6">
    <div class="card">
        <div class="card-header">
            <h2>{{ $status }}</h2>
        </div>
        <div class="card-body">
            @if($status == "Đáp án chính xác!")
                <div class="alert alert-success mb-6">
                    <div class="alert-content">
                        <h4 class="alert-title">Congratulations!</h4>
                        <p>You have successfully solved this challenge.</p>
                    </div>
                </div>
                
                <div class="mb-4">
                    <h3 class="text-lg font-semibold mb-2">Challenge Content:</h3>
                </div>
                
                <div class="bg-gray-100 rounded-lg p-5 whitespace-pre-wrap font-mono text-sm">
                    {{ $content }}
                </div>
            @else
                <div class="alert alert-warning">
                    <div class="alert-content">
                        <h4 class="alert-title">Sorry!</h4>
                        <p>{{ $status }}</p>
                    </div>
                </div>
                
                <div class="mt-6">
                    <a href="{{ route('challenge.detail', ['cid' => $challenge->cid]) }}" class="btn btn-primary">
                        <i class="fas fa-redo btn-icon"></i>
                        <span>Try Again</span>
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection