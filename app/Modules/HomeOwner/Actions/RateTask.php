<?php

namespace App\Modules\HomeOwner\Actions;

use App\Modules\ServiceProvider\Models\Task;
use App\Modules\Shared\Models\User;

class RateTask
{
    public function execute(int $taskId, int $rating, string $reviewTitle, string $review)
    {
        $task = Task::findOrFail($taskId);

        $task->rating = $rating;
        $task->review_title = $reviewTitle;
        $task->review = $review;
        $task->reviewed_at = now();
        $task->save();

        User::where('id', $task->service_provider_id)
            ->update([
                'rating' => Task::where('service_provider_id', $task->service_provider_id)
                    ->whereNotNull('rating')
                    ->avg('rating')
            ]);
    }
}
