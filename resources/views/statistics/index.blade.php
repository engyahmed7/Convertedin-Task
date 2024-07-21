@extends('layouts.app')

@section('title', 'Task Statistics')

@section('content')
    <div class="container mt-3">
        <h1 class="text-center mb-4">Task Statistics</h1>
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Top 10 Users with Highest Task Count</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>User</th>
                                <th>Task Count</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($statistics as $stat)
                                <tr>
                                    <td>{{ $stat->user->name }}</td>
                                    <td>{{ $stat->task_count }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
