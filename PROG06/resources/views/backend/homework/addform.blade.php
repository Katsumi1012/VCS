@extends('layouts.app')

@section('content')
<div class="page-header">
    <h1 class="page-title">Add Homework</h1>
    <div>
        <a href="{{ route('homework.index') }}" class="btn btn-light">
            <i class="fas fa-arrow-left btn-icon"></i>
            <span>Back</span>
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('homework.add') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group">
                <label for="file" class="form-label">Homework File</label>
                <input type="file" id="file" name="filename" class="form-control @error('filename') is-invalid @enderror" required>
                @error('filename')
                    <div class="form-error">{{ $message }}</div>
                @enderror
                <div class="mt-2 text-sm text-gray-500">
                    Upload your homework document (PDF, DOCX, or other document formats).
                </div>
            </div>
            
            <div class="form-group">
                <label for="description" class="form-label">Description</label>
                <textarea id="description" name="description" rows="4" class="form-control @error('description') is-invalid @enderror"></textarea>
                @error('description')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="due_date" class="form-label">Due Date (Optional)</label>
                <input type="date" id="due_date" name="due_date" class="form-control @error('due_date') is-invalid @enderror">
                @error('due_date')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group mb-0">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-upload btn-icon"></i>
                    <span>Upload Homework</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(function() {
        styleFileInputs();
    });
</script>
@endpush
