<?php

namespace App\Http\Livewire\Admin\SupportTicket;

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
            ->leftJoin('users as home_owner', 'home_owner.id', '=', 'tasks.home_owner_id')
            ->leftJoin('users as service_provider', 'service_provider.id', '=', 'tasks.service_provider_id')
            ->select(['support_tickets.*', 'home_owner.username as home_owner', 'service_provider.username as service_provider'])
            ->when($this->filters['search'] ?? null, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('home_owner.username', 'LIKE', $search . '%')
                        ->orWhere('service_provider.username', 'LIKE', $search . '%');
                });
            })
            ->when($this->filters['status'] ?? null, fn ($query, $status) => $query->where('support_tickets.status', $status))
            ->when($this->filters['created_at'] ?? null, fn ($query, $createdAt) => $query->whereBetween('support_tickets.created_at', date_range_filter_transformer($createdAt)));

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
        return view('livewire.admin.support-ticket.support-ticket-index', [
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
