@extends('layouts.app')

@section('content')
<div class="page-header">
    <h1 class="page-title">Messages</h1>
</div>

<div class="grid grid-cols-1 gap-6">
    <div class="card">
        <div class="card-header">
            <h2>Sent Messages</h2>
        </div>
        <div class="card-body">
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Recipient</th>
                            <th>Message</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sent_msg as $sent)
                        <tr>
                            <td>{{ $sent->id }}</td>
                            <td>{{ $sent->receiver_name }}</td>
                            <td>{{ $sent->msg }}</td>
                            <td>{{ $sent->created_at instanceof \DateTime ? $sent->created_at->format('M d, Y H:i') : $sent->created_at }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="card-header">
            <h2>Received Messages</h2>
        </div>
        <div class="card-body">
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Sender</th>
                            <th>Message</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($received_msg as $received)
                        <tr>
                            <td>{{ $received->id }}</td>
                            <td>{{ $received->sender_name }}</td>
                            <td>{{ $received->msg }}</td>
                            <td>{{ $received->created_at instanceof \DateTime ? $received->created_at->format('M d, Y H:i') : $received->created_at }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection