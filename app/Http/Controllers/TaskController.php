<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use App\Models\Admin;
use App\Models\Statistic;
use App\Jobs\UpdateStatistics;

class TaskController extends Controller
{
    public function create()
    {
        $admins = Admin::all();
        $users = User::all();
        return view('tasks.create', compact('admins', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'assigned_to_id' => 'required|exists:users,id',
            'assigned_by_id' => 'required|exists:admins,id',
        ]);

        // Task::create($request->only('title', 'description', 'assigned_to_id', 'assigned_by_id'));
        Task::create($request->all());
        UpdateStatistics::dispatch();

        return redirect()->route('tasks.index');
    }

    public function index()
    {
        $tasks = Task::with('assignedTo', 'assignedBy')->paginate(10);
        return view('tasks.index', compact('tasks'));
    }
}
