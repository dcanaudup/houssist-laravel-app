<?php

namespace App\Http\Livewire\HomeOwner\Task;

use App\Http\Livewire\Traits\WithCachedRows;
use App\Http\Livewire\Traits\WithLockedPublicPropertiesTrait;
use App\Http\Livewire\Traits\WithPerPagination;
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
    use WithCachedRows, WithPerPagination, WithLockedPublicPropertiesTrait, WithFileUploads;

    /** @locked  */
    public ?int $task_id = null;

    public $showDisputeModal = false;

    public $showTaskModal = false;

    public NewSupportTicketData $newSupportTicketData;

    public NewSupportTicketMessageData $newSupportTicketMessageData;

    public $attachments = [];

    public function getRowsQueryProperty()
    {
        return Task::query()
            ->where('home_owner_id', auth()->id())
            ->with('advertisement', 'advertisement_offer', 'service_provider');
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
        $this->newSupportTicketData->attachments = $this->attachments;

        $createSupportTicket->execute($this->newSupportTicketData);
        $fileDispute->execute($this->task_id);
        $this->showTaskModal = false;
        $this->dispatchBrowserEvent('notify', ['message' => 'Task dispute filed successfully']);
    }
}
