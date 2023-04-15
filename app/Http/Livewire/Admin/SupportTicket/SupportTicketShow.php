<?php

namespace App\Http\Livewire\Admin\SupportTicket;

use App\Modules\Admin\Actions\CloseForHomeOwner;
use App\Modules\Admin\Actions\CloseForServiceProvider;
use App\Modules\Shared\Actions\CreateSupportTicketMessage;
use App\Modules\Shared\DataTransferObjects\NewSupportTicketMessageData;
use App\Modules\Shared\Models\SupportTicket;
use App\Modules\Shared\Models\User;
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
            ->leftJoin('users as home_owner', 'home_owner.id', '=', 'tasks.home_owner_id')
            ->leftJoin('users as service_provider', 'service_provider.id', '=', 'tasks.service_provider_id')
            ->select(['support_tickets.*', 'home_owner.id as home_owner_id', 'service_provider.id as service_provider_id'])
            ->with('messages.user')
            ->findOrFail($this->supportTicketId);
    }

    public function render()
    {
        return view('livewire.admin.support-ticket.support-ticket-show', [
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

    public function closeForHomeOwner(CloseForHomeOwner $closeForHomeOwner, int $userId)
    {
        $user = User::with('wallet')->findOrFail($userId);
        $supportTicket = SupportTicket::with('task.advertisement_offer')->findOrFail($this->supportTicketId);

        $closeForHomeOwner->execute($supportTicket, $user);

        $this->dispatchBrowserEvent('notify', ['message' => 'Ticket was closed in favor of the home owner!']);
        return redirect()->route('admin.support-tickets');
    }

    public function closeForServiceProvider(CloseForServiceProvider $closeForServiceProvider, int $userId)
    {
        $user = User::with('wallet')->findOrFail($userId);
        $supportTicket = SupportTicket::with('task.advertisement_offer')->findOrFail($this->supportTicketId);

        $closeForServiceProvider->execute($supportTicket, $user);

        $this->dispatchBrowserEvent('notify', ['message' => 'Ticket was closed in favor of the service provider!']);
        return redirect()->route('admin.support-tickets');
    }
}
