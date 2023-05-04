<?php

namespace App\Http\Livewire\HomeOwner\Task;

use App\Http\Livewire\Traits\WithCachedRows;
use App\Http\Livewire\Traits\WithLockedPublicPropertiesTrait;
use App\Http\Livewire\Traits\WithPerPagination;
use App\Http\Livewire\Traits\WithRating;
use App\Http\Livewire\Traits\WithSorting;
use App\Modules\HomeOwner\Actions\FileDispute;
use App\Modules\HomeOwner\Actions\ReleasePayment;
use App\Modules\ServiceProvider\Models\Task;
use App\Modules\Shared\Actions\CreateSupportTicket;
use App\Modules\Shared\DataTransferObjects\NewSupportTicketData;
use App\Modules\Shared\DataTransferObjects\NewSupportTicketMessageData;
use App\Modules\Shared\Enums\SupportTicketType;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Livewire\WithFileUploads;

class TaskIndex extends Component
{
    use WithCachedRows, WithPerPagination, WithLockedPublicPropertiesTrait, WithFileUploads, WithSorting, WithRating;

    public $showFilters = false;

    public $filters = [
        'search' => null,
        'status' => null,
        'job_date_time' => null,
    ];

    protected $queryString = ['filters', 'sorts'];

    /** @locked  */
    public ?int $task_id = null;

    public $showDisputeModal = false;

    public $showTaskModal = false;

    public NewSupportTicketData $newSupportTicketData;

    public NewSupportTicketMessageData $newSupportTicketMessageData;

    public $attachments = [];

    public function getRowsQueryProperty()
    {
        $query = Task::query()
            ->join('advertisements', 'advertisements.advertisement_id', '=', 'tasks.advertisement_id')
            ->join('users as service_provider_user', 'service_provider_user.id', '=', 'tasks.service_provider_id')
            ->select([
                'tasks.*', 'advertisements.title', 'advertisements.description', 'advertisements.payment_method',
                'advertisements.start_date_time', 'advertisements.end_date_time', 'advertisements.job_payment_type',
            ])
            ->where('tasks.home_owner_id', auth()->id())
            ->when($this->filters['search'] ?? null, fn($query, $search) => $query->where(function ($q) use ($search) {
                $q->where('advertisements.title', 'like', "{$search}%")
                    ->orWhere('advertisements.description', 'like', "{$search}%")
                    ->orWhere('service_provider_user.username', 'like', "{$search}%");
            }))
            ->when($this->filters['job_date_time'] ?? null, fn($query, $jobDateTime) => $query->where(function ($q) use ($jobDateTime) {
                $q->whereBetween('advertisements.start_date_time', date_range_filter_transformer($jobDateTime))
                    ->orWhereBetween('advertisements.end_date_time', date_range_filter_transformer($jobDateTime));
            }))
            ->when($this->filters['status'] ?? null, fn($query, $status) => $query->where('tasks.status', $status))
            ->when($this->filters['payment_method'] ?? null, fn($query, $status) => $query->where('payment_method', $status))
            ->with('advertisement_offer', 'service_provider');

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
            return Task::findOrFail($this->task_id);
        }) : null;
    }

    public function mount()
    {
        $this->newSupportTicketData = NewSupportTicketData::initialize();
    }

    public function render()
    {
        return view('livewire.home-owner.task.task-index', [
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

    public function releasePayment(int $taskId, ReleasePayment $releasePayment)
    {
        $releasePayment->execute($taskId);
        $this->showTaskModal = false;
        $this->dispatchBrowserEvent('notify', ['message' => 'Task payment released successfully']);
    }

    public function openDispute()
    {
        $this->useCachedRows();
        $this->showTaskModal = false;
        $this->showDisputeModal = true;
    }

    public function fileDispute(FileDispute $fileDispute, CreateSupportTicket $createSupportTicket)
    {
        $this->validate([
            'attachments' => 'nullable',
            'attachments.*' => 'file|mimes:jpeg,png,jpg,pdf|max:2048',
            'newSupportTicketData.message.message' => 'required',
        ]);
        $this->newSupportTicketData->user_id = auth()->id();
        $this->newSupportTicketData->task_id = $this->task_id;
        $this->newSupportTicketData->subject = 'Task Dispute for task #'.$this->task_id;
        $this->newSupportTicketData->support_ticket_type = SupportTicketType::TASK_DISPUTE;

        $createSupportTicket->execute($this->newSupportTicketData, $this->attachments);
        $fileDispute->execute($this->task_id);
        $this->showDisputeModal = false;
        $this->reset('attachments');
        $this->dispatchBrowserEvent('notify', ['message' => 'Task dispute filed successfully']);
    }

    public function toggleShowFilters()
    {
        $this->useCachedRows();

        $this->showFilters = ! $this->showFilters;
    }

    public function resetFilters() { $this->reset('filters'); }
}
