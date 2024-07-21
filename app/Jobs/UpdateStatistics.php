<?php
namespace App\Jobs;

use App\Models\Statistic;
use App\Models\Task;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateStatistics implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
        //
    }

    public function handle()
    {
        $userTaskCounts = Task::selectRaw('assigned_to_id, COUNT(*) as task_count')
            ->groupBy('assigned_to_id')
            ->get();

        foreach ($userTaskCounts as $count) {
            Statistic::updateOrCreate(
                ['user_id' => $count->assigned_to_id],
                ['task_count' => $count->task_count]
            );
        }
    }
}
