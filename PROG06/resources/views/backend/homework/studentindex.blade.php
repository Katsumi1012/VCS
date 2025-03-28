@extends('layouts.app')

@section('content')
<div class="page-header">
    <h1 class="page-title">Homework</h1>
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
                            <a href="{{ route('homework.addsolutionform', ['tid' => $task->task_id]) }}" class="btn btn-sm btn-success">
                                <i class="fas fa-paper-plane btn-icon"></i>
                                <span>Submit Solution</span>
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