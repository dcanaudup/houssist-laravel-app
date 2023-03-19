<?php

namespace App\Http\Livewire\Shared\SupportTicket;

use App\Modules\Shared\Actions\CreateSupportTicketMessage;
use App\Modules\Shared\DataTransferObjects\NewSupportTicketMessageData;
use App\Modules\Shared\Models\SupportTicket;
use Livewire\Component;

class SupportTicketShow extends Component
{
    /** @locked  */
    public $supportTicketId;

    public NewSupportTicketMessageData $newSupportTicketMessageData;

    public function mount(int $supportTicket)
    {
        $this->supportTicketId = $supportTicket;

        $this->newSupportTicketMessageData = NewSupportTicketMessageData::initialize();
    }

    public function getSupportTicketProperty()
    {
        return SupportTicket::leftJoin('tasks', 'tasks.task_id', '=', 'support_tickets.task_id')
            ->where(function ($query) {
                $query->where('user_id', auth()->id())
                    ->orWhere('tasks.service_provider_id', auth()->id());
            })
            ->select(['support_tickets.*'])
            ->with('messages.user')
            ->findOrFail($this->supportTicketId);
    }

    public function render()
    {
        return view('livewire.shared.support-ticket.support-ticket-show', [
            'supportTicket' => $this->support_ticket,
        ]);
    }

    public function save(CreateSupportTicketMessage $createSupportTicketMessage)
    {
        $this->validate([
            'newSupportTicketMessageData.message' => 'required|string',
        ]);

        $this->newSupportTicketMessageData->support_ticket_id = $this->supportTicketId;
        $this->newSupportTicketMessageData->user_id = auth()->id();
        $createSupportTicketMessage->execute($this->newSupportTicketMessageData);
        $this->newSupportTicketMessageData = NewSupportTicketMessageData::initialize();
        $this->support_ticket->refresh();
        $this->dispatchBrowserEvent('notify', ['message' => 'Message sent successfully!']);
    }
}
