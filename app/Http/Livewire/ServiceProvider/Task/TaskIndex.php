<?php

namespace App\Http\Livewire\ServiceProvider\Task;

use App\Http\Livewire\Traits\WithCachedRows;
use App\Http\Livewire\Traits\WithPerPagination;
use App\Modules\ServiceProvider\Models\Task;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TaskIndex extends Component
{
    use WithCachedRows, WithPerPagination;

    public function getRowsQueryProperty()
    {
        return Task::query()
            ->where('service_provider_id', auth()->id())
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
        return view('livewire.service-provider.task.task-index', [
            'tasks' => $this->rows,
        ]);
    }
}
