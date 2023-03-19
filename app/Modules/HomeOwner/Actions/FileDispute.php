<?php

namespace App\Modules\HomeOwner\Actions;

use App\Modules\ServiceProvider\Enums\TaskStatus;
use App\Modules\ServiceProvider\Models\Task;

class FileDispute
{
    public function execute(int $taskId)
    {
        $task = Task::findOrFail($taskId);
        $task->status = TaskStatus::DISPUTE;
        $task->save();
    }
}
