@extends('layouts.app')

@section('content')
<div class="page-header">
    <h1 class="page-title">Teachers</h1>
    <div>
        <a href="{{ route('teacher.create') }}" class="btn btn-primary">
            <i class="fas fa-plus btn-icon"></i>
            <span>Add Teacher</span>
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($teachers as $teacher)
                    <tr>
                        <td>{{ $teacher->user->name }}</td>
                        <td>{{ $teacher->user->email }}</td>
                        <td>{{ $teacher->phone }}</td>
                        <td class="text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('teacher.edit', $teacher->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('teacher.show', $teacher->id) }}" class="btn btn-sm btn-success">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form action="{{ route('teacher.destroy', $teacher->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this teacher?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        <div class="pagination">
            {{ $teachers->links() }}
        </div>
    </div>
</div>
@endsection