@extends('layouts.app')
@section('content')
    <div class="page-header">
        <h1 class="page-title">Challenge List</h1>
    </div>
    
    <div class="card">
        <div class="card-body">
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Challenge Name</th>
                            <th>Hint</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($challenge as $chall)
                            <tr>
                                <td>{{ $chall->cid }}</td>
                                <td>Challenge #{{ $chall->cid }}</td>
                                <td>{{ $chall->hint }}</td>
                                <td>
                                    <a href="{{ route('challenge.detail', $chall->cid) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-puzzle-piece btn-icon"></i>
                                        <span>Solve Challenge</span>
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