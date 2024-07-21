@extends('layouts.app')

@section('title', 'Task List')

@section('content')
    <div class="container mt-3">
        <h1 class="text-center mb-4">Task List</h1>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Title</th>
                        <th scope="col">Description</th>
                        <th scope="col">Assigned User</th>
                        <th scope="col">Admin</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tasks as $task)
                        <tr>
                            <td>{{ $task->title }}</td>
                            <td>{{ $task->description }}</td>
                            <td>{{ $task->assignedTo->name }}</td>
                            <td>{{ $task->assignedBy->name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center">
            {{ $tasks->links() }}
        </div>
    </div>
@endsection
