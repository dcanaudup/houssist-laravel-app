<?php

namespace App\Modules\HomeOwner\Actions;

use App\Modules\ServiceProvider\Enums\TaskStatus;
use App\Modules\ServiceProvider\Models\Task;
use App\Notifications\PaymentReleased;
use Illuminate\Support\Facades\Notification;

class ReleasePayment
{
    public function execute(int $taskId)
    {
        $task = Task::where('task_id', $taskId)
            ->with('service_provider')
            ->firstOrFail();
        $task->status = TaskStatus::PAID;
        $task->save();

        Notification::send($task->service_provider, new PaymentReleased());
    }
}
