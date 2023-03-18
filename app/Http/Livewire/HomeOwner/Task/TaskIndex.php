<?php

namespace App\Http\Livewire\HomeOwner\Task;

use App\Http\Livewire\Traits\WithCachedRows;
use App\Http\Livewire\Traits\WithPerPagination;
use App\Modules\ServiceProvider\Models\Task;
use Livewire\Component;

class TaskIndex extends Component
{
    use WithCachedRows, WithPerPagination;

    public function getRowsQueryProperty()
    {
        return Task::query()
            ->where('home_owner_id', auth()->id())
            ->with('advertisement', 'advertisement_offer');
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function render()
    {
        return view('livewire.home-owner.task.task-index', [
            'tasks' => $this->rows,
        ]);
    }
}
