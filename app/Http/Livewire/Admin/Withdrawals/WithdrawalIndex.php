<?php

namespace App\Http\Livewire\Admin\Withdrawals;

use App\Http\Livewire\Traits\WithCachedRows;
use App\Http\Livewire\Traits\WithPerPagination;
use App\Http\Livewire\Traits\WithSorting;
use App\Models\Withdrawal;
use App\Modules\Admin\Actions\ApproveWithdrawal;
use App\Modules\Admin\Actions\RejectWithdrawal;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class WithdrawalIndex extends Component
{
    use WithCachedRows, WithPerPagination, WithSorting;

    public $showFilters = false;

    public $filters = [
        'search' => null,
        'withdrawal_type' => null,
        'created_at' => null,
    ];

    protected $queryString = ['filters', 'sorts'];

    public $showViewModal = false;

    public $withdrawal_id;

    public $admin_remarks;

    public function getRowsQueryProperty()
    {
        $query = Withdrawal::query()
            ->join('users', 'users.id', '=', 'withdrawals.user_id')
            ->with('user')
            ->when($this->filters['search'] ?? null, fn ($query, $search) => $query->where('users.username', 'LIKE', $search . '%'))
            ->when($this->filters['withdrawal_type'] ?? null, fn ($query, $withdrawalType) => $query->where('withdrawal_type', $withdrawalType))
            ->when($this->filters['status'] ?? null, fn ($query, $status) => $query->where('status', $status))
            ->when($this->filters['created_at'] ?? null, fn ($query, $createdAt) => $query->whereBetween('created_at', date_range_filter_transformer($createdAt)));

        return $this->applySorting($query);
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function getViewWithdrawalProperty()
    {
        return $this->withdrawal_id ? Cache::remember(Withdrawal::CACHE_KEY.$this->withdrawal_id, 300, function () {
            return Withdrawal::with('user')->findOrFail($this->withdrawal_id);
        }) : null;
    }

    public function render()
    {
        return view('livewire.admin.withdrawals.withdrawal-index', [
            'withdrawals' => $this->rows,
            'viewWithdrawal' => $this->viewWithdrawal,
        ]);
    }

    public function view(int $withdrawalId)
    {
        $this->useCachedRows();
        $this->withdrawal_id = $withdrawalId;
        $this->showViewModal = true;
    }

    public function toggleShowFilters()
    {
        $this->useCachedRows();

        $this->showFilters = ! $this->showFilters;
    }

    public function resetFilters()
    {
        $this->reset('filters');
    }

    public function approve(ApproveWithdrawal $approveWithdrawal, int $withdrawalId)
    {
        $approveWithdrawal->execute(Withdrawal::findOrFail($withdrawalId), $this->admin_remarks);

        $this->showViewModal = false;

        $this->dispatchBrowserEvent('notify', ['message' => 'Withdrawal has been approved.']);
    }

    public function reject(RejectWithdrawal $rejectWithdrawal, int $withdrawalId)
    {
        $rejectWithdrawal->execute(Withdrawal::query()->with('user.wallet')->findOrFail($withdrawalId), $this->admin_remarks);

        $this->showViewModal = false;

        $this->dispatchBrowserEvent('notify', ['message' => 'Withdrawal has been rejected.']);
    }
}
