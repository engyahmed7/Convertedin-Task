<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Statistic;
use Illuminate\Support\Facades\DB;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'assigned_to_id',
        'assigned_by_id',
    ];

    public static function boot()
    {
        parent::boot();

        static::created(function ($task) {
            Statistic::updateOrCreate(
                ['user_id' => $task->assigned_to_id],
                ['task_count' => DB::raw('task_count + 1')]
            );
        });

        static::deleted(function ($task) {
            $stat = Statistic::where('user_id', $task->assigned_to_id)->first();
            if ($stat) {
                $stat->task_count = $stat->task_count - 1;
                if ($stat->task_count <= 0) {
                    $stat->delete();
                } else {
                    $stat->save();
                }
            }
        });
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to_id');
    }

    public function assignedBy()
    {
        return $this->belongsTo(Admin::class, 'assigned_by_id');
    }
}
