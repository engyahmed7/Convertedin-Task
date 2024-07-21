<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Statistic;

class StatisticsController extends Controller
{
    public function index()
    {
        $statistics = Statistic::with('user')
            ->orderBy('task_count', 'desc')
            ->take(10)
            ->get();

        return view('statistics.index', compact('statistics'));
    }
}
