<?php

namespace App\Modules\ServiceProvider\Actions;

use App\Modules\ServiceProvider\Enums\TaskStatus;
use App\Modules\ServiceProvider\Models\Task;
use App\Notifications\TaskCompleted;
use Illuminate\Support\Facades\Notification;

class CompleteTask
{
    public function execute(int $taskId)
    {
        $task = Task::where('task_id', $taskId)
            ->with('home_owner')
            ->firstOrFail();
        $task->status = TaskStatus::COMPLETED;
        $task->save();

        Notification::send($task->home_owner, new TaskCompleted());
    }
}
