<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{

    public function index()
    {
        Log::info('Auth check for admin: ' . Auth::guard('admin')->check());
        Log::info('Auth check for web: ' . Auth::guard('web')->check());

        if (Auth::guard('admin')->check()) {
            $tasks = Task::with('assignedTo', 'assignedBy')->paginate(10);
        } elseif (Auth::guard('web')->check()) {
            $tasks = Task::where('assigned_to_id', Auth::id())->with('assignedTo', 'assignedBy')->paginate(10);
        } else {
            return redirect()->route('login');
        }

        return view('tasks.index', compact('tasks'));
    }

}
