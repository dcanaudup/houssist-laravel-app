<?php

namespace App\Modules\ServiceProvider\Actions;

use App\Modules\ServiceProvider\Enums\TaskStatus;
use App\Modules\ServiceProvider\Models\Task;

class CompleteTask
{
    public function execute(int $taskId)
    {
        $task = Task::findOrFail($taskId);
        $task->status = TaskStatus::COMPLETED;
        $task->save();
    }
}
