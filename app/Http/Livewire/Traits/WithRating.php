<?php

namespace App\Http\Livewire\Traits;

use App\Modules\HomeOwner\Actions\RateServiceProvider;
use App\Modules\HomeOwner\Actions\RateTask;
use App\Modules\ServiceProvider\Models\Task;

trait WithRating
{
    public $showDoRateModal = false;

    public $rating;

    public $review_title;

    public $review;

    public function getTaskQueryProperty()
    {
        return Task::query()
            ->where('task_id', $this->task_id)
            ->select(['task_id', 'service_provider_id', 'home_owner_id']);
    }

    public function getTaskProperty()
    {
        if (!$this->task_id) {
            return null;
        }

        return $this->cache(function () {
            return $this->taskQuery->first();
        }, 'task_');
    }

    public function rate(int $taskId)
    {
        $this->useCachedRows();
        $this->task_id = $taskId;
        $this->showDoRateModal = true;
    }

    public function submitRating(RateTask $rateTask)
    {
        $this->validate([
            'rating' => 'required|numeric|min:1|max:5',
            'review_title' => 'required|string|max:255',
            'review' => 'required|string|max:255',
        ]);

        $rateTask->execute(
            $this->task_id,
            $this->rating,
            $this->review_title,
            $this->review
        );
        $this->dispatchBrowserEvent('notify', ['message' => 'Review Submitted!']);

        $this->rating = null;
        $this->review_title = null;
        $this->review = null;
        $this->showDoRateModal = false;
    }

    public function closeDoRateModal()
    {
        $this->useCachedRows();
        $this->showDoRateModal = false;
    }
}
