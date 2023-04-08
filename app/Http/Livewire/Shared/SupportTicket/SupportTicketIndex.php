<?php

namespace App\Http\Livewire\Shared\SupportTicket;

use App\Http\Livewire\Traits\WithCachedRows;
use App\Http\Livewire\Traits\WithLockedPublicPropertiesTrait;
use App\Http\Livewire\Traits\WithPerPagination;
use App\Http\Livewire\Traits\WithSorting;
use App\Modules\Shared\Models\SupportTicket;
use Livewire\Component;

class SupportTicketIndex extends Component
{
    use WithPerPagination, WithCachedRows, WithLockedPublicPropertiesTrait, WithSorting;

    public $showFilters = false;

    public $filters = [
        'search' => null,
        'status' => null,
        'created_at' => null,
    ];

    protected $queryString = ['filters', 'sorts'];

    public function getRowsQueryProperty()
    {
        $query = SupportTicket::leftJoin('tasks', 'tasks.task_id', '=', 'support_tickets.task_id')
            ->where(function ($query) {
                $query->where('user_id', auth()->id())
                    ->orWhere('tasks.service_provider_id', auth()->id());
            })
            ->select(['support_tickets.*']);

        return $this->applySorting($query);
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

    public function toggleShowFilters()
    {
        $this->useCachedRows();

        $this->showFilters = ! $this->showFilters;
    }

    public function resetFilters() { $this->reset('filters'); }
}
