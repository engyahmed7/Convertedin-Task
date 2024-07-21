<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use App\Models\Admin;
use App\Models\Statistic;
use App\Jobs\UpdateStatistics;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreTaskRequest;

class TaskController extends Controller
{
    public function create()
    {
        $admins = Admin::all();
        $users = User::all();
        return view('tasks.create', compact('admins', 'users'));
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

        return redirect('/tasks')->with('success', 'Task created successfully!');
    }


    public function index()
    {
        $tasks = Task::with('assignedTo', 'assignedBy')->paginate(10);
        return view('tasks.index', compact('tasks'));
    }
}
