<?php

namespace App\Http\Livewire\Admin\Task;

use App\Http\Livewire\Traits\WithCachedRows;
use App\Http\Livewire\Traits\WithLockedPublicPropertiesTrait;
use App\Http\Livewire\Traits\WithPerPagination;
use App\Http\Livewire\Traits\WithSorting;
use App\Modules\ServiceProvider\Models\Task;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Livewire\WithFileUploads;

class TaskIndex extends Component
{
    use WithCachedRows, WithPerPagination, WithLockedPublicPropertiesTrait, WithSorting;

    public $showFilters = false;

    public $filters = [
        'search' => null,
        'status' => null,
        'job_date_time' => null,
    ];

    protected $queryString = ['filters', 'sorts'];

    /** @locked  */
    public ?int $task_id = null;

    public $showTaskModal = false;

    public function getRowsQueryProperty()
    {
        $query = Task::query()
            ->join('advertisements', 'advertisements.advertisement_id', '=', 'tasks.advertisement_id')
            ->join('users as service_provider_user', 'service_provider_user.id', '=', 'tasks.service_provider_id')
            ->join('users as home_owner_user', 'home_owner_user.id', '=', 'tasks.home_owner_id')
            ->select([
                'tasks.*', 'advertisements.title',
                'advertisements.start_date_time', 'advertisements.end_date_time', 'advertisements.job_payment_type',
            ])
            ->when($this->filters['search'] ?? null, fn($query, $search) => $query->where(function ($q) use ($search) {
                $q->where('advertisements.title', 'like', "{$search}%")
                    ->orWhere('advertisements.description', 'like', "{$search}%")
                    ->orWhere('service_provider_user.username', 'like', "{$search}%")
                    ->orWhere('home_owner_user.username', 'like', "{$search}%");
            }))
            ->when($this->filters['job_date_time'] ?? null, fn($query, $jobDateTime) => $query->where(function ($q) use ($jobDateTime) {
                $q->whereBetween('advertisements.start_date_time', date_range_filter_transformer($jobDateTime))
                    ->orWhereBetween('advertisements.end_date_time', date_range_filter_transformer($jobDateTime));
            }))
            ->when($this->filters['status'] ?? null, fn($query, $status) => $query->where('tasks.status', $status))
            ->with('advertisement_offer', 'service_provider', 'home_owner');

        return $this->applySorting($query);
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
            return Task::with('service_provider', 'home_owner', 'advertisement_offer')->findOrFail($this->task_id);
        }) : null;
    }

    public function render()
    {
        return view('livewire.admin.task.task-index', [
            'tasks' => $this->rows,
            'viewTask' => $this->view_task,
        ]);
    }

    public function closeView()
    {
        $this->useCachedRows();
        $this->showTaskModal = false;
    }

    public function view(int $taskId)
    {
        $this->useCachedRows();
        $this->task_id = $taskId;
        $this->showTaskModal = true;
    }

    public function toggleShowFilters()
    {
        $this->useCachedRows();

        $this->showFilters = ! $this->showFilters;
    }

    public function resetFilters() { $this->reset('filters'); }
}
