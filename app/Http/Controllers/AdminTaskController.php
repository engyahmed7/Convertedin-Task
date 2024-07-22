<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use App\Models\Admin;
use App\Jobs\UpdateStatistics;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreTaskRequest;

class AdminTaskController extends Controller
{

    public function index()
    {
        $tasks = Task::with('assignedTo', 'assignedBy')->paginate(10);
        return view('tasks.index', compact('tasks'));
    }
    public function create()
    {
        $users = User::all();
        $admins = Admin::all();
        return view('tasks.create', compact(['users', 'admins']));
    }

    public function store(StoreTaskRequest $request)
    {
        Log::info('Request data:', $request->all());

        try {
            Task::create($request->validated());
            UpdateStatistics::dispatch();
        } catch (\Exception $e) {
            Log::error('Error creating task: ' . $e->getMessage());
            throw $e;
        }

        return redirect()->route('admin.tasks.index')->with('success', 'Task created successfully!');
    }
}
