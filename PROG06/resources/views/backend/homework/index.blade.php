@extends('layouts.app')

@section('content')
<div class="page-header">
    <h1 class="page-title">Homework</h1>
    <div>
        <a href="{{ route('homework.addform') }}" class="btn btn-primary">
            <i class="fas fa-plus btn-icon"></i>
            <span>Add Homework</span>
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Homework</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($homeworklist as $task)
                    <tr>
                        <td>{{ $task->task_id }}</td>
                        <td>
                            <a href="{{ route('homework.download', $task->filename) }}" class="text-primary hover:underline">
                                {{ $task->filename }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('homework.solutionlist', ['tid' => $task->task_id]) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-list-check btn-icon"></i>
                                <span>View Submissions</span>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection