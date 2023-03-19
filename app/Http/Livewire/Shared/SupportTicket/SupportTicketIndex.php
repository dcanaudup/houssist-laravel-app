<?php

namespace App\Http\Livewire\Shared\SupportTicket;

use App\Http\Livewire\Traits\WithCachedRows;
use App\Http\Livewire\Traits\WithPerPagination;
use App\Modules\Shared\Models\SupportTicket;
use Livewire\Component;

class SupportTicketIndex extends Component
{
    use WithPerPagination, WithCachedRows;

    public function getRowsQueryProperty()
    {
        return SupportTicket::leftJoin('tasks', 'tasks.task_id', '=', 'support_tickets.task_id')
            ->where(function ($query) {
                $query->where('user_id', auth()->id())
                    ->orWhere('tasks.service_provider_id', auth()->id());
            })
            ->select(['support_tickets.*']);
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function render()
    {
        return view('livewire.shared.support-ticket.support-ticket-index', [
            'supportTickets' => $this->rows,
        ]);
    }
}
