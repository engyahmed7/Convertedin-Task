<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use App\Models\Admin;
use App\Models\Statistic;
use App\Jobs\UpdateStatistics;
use Illuminate\Support\Facades\Log;


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
        Log::info('Request data:', $request->all());

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'assigned_to_id' => 'required|exists:users,id',
            'assigned_by_id' => 'required|exists:admins,id',
        ]);

        try {
            Task::create($request->all());
            UpdateStatistics::dispatch();
        } catch (\Exception $e) {
            Log::error('Error creating task: ' . $e->getMessage());
            throw $e;
        }

        return redirect('/tasks');
    }


    public function index()
    {
        $tasks = Task::with('assignedTo', 'assignedBy')->paginate(10);
        return view('tasks.index', compact('tasks'));
    }
}
