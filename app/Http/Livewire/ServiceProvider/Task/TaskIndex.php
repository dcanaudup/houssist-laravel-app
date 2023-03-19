<?php

namespace App\Http\Livewire\ServiceProvider\Task;

use App\Http\Livewire\Traits\WithCachedRows;
use App\Http\Livewire\Traits\WithLockedPublicPropertiesTrait;
use App\Http\Livewire\Traits\WithPerPagination;
use App\Modules\ServiceProvider\Actions\CompleteTask;
use App\Modules\ServiceProvider\Models\Task;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class TaskIndex extends Component
{
    use WithCachedRows, WithPerPagination, WithLockedPublicPropertiesTrait;

    /** @locked  */
    public ?int $task_id = null;

    public $showTaskModal = false;

    public function getRowsQueryProperty()
    {
        return Task::query()
            ->where('service_provider_id', auth()->id())
            ->with('advertisement', 'advertisement_offer', 'home_owner');
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function getViewTaskProperty()
    {
        return $this->task_id ? Cache::remember(Task::CACHE_KEY.$this->task_id, 300, function () {
            return Task::findOrFail($this->task_id);
        }) : null;
    }

    public function render()
    {
        return view('livewire.service-provider.task.task-index', [
            'tasks' => $this->rows,
            'viewTask' => $this->view_task,
        ]);
    }

    public function view(int $taskId)
    {
        $this->useCachedRows();
        $this->task_id = $taskId;
        $this->showTaskModal = true;
    }

    public function closeView()
    {
        $this->useCachedRows();
        $this->showTaskModal = false;
    }

    public function completeTask(int $taskId, CompleteTask $completeTask)
    {
        $this->useCachedRows();
        $completeTask->execute($taskId);
        $this->showTaskModal = false;
        $this->dispatchBrowserEvent('notify', ['message' => 'Task is completed']);
    }
}
