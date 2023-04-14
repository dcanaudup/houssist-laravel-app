<?php

namespace App\Http\Livewire\Shared\Withdrawals;

use App\Http\Livewire\Traits\WithCachedRows;
use App\Http\Livewire\Traits\WithPerPagination;
use App\Http\Livewire\Traits\WithSorting;
use App\Models\Withdrawal;
use App\Modules\Shared\Actions\CancelWithdrawal;
use App\Modules\Shared\Actions\CreateWithdrawal;
use App\Modules\Shared\DataTransferObjects\WithdrawalData;
use App\Modules\Shared\Enums\WithdrawalStatus;
use App\Modules\Shared\Enums\WithdrawalType;
use App\Modules\Shared\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Enum;
use Livewire\Component;

class WithdrawalIndex extends Component
{
    use WithCachedRows, WithPerPagination, WithSorting;

    public $showFilters = false;

    public $filters = [
        'withdrawal_type' => null,
        'created_at' => null,
    ];

    protected $queryString = ['filters', 'sorts'];

    public $showCreateModal = false;

    public $showViewModal = false;

    public WithdrawalData $newWithdrawal;

    public $withdrawal_id;

    public function mount()
    {
        $this->initializeWithdrawal();
    }

    public function getRowsQueryProperty()
    {
        $query = Withdrawal::query()
            ->when($this->filters['withdrawal_type'] ?? null, fn ($query, $withdrawalType) => $query->where('withdrawal_type', $withdrawalType))
            ->when($this->filters['status'] ?? null, fn ($query, $status) => $query->where('status', $status))
            ->when($this->filters['created_at'] ?? null, fn ($query, $createdAt) => $query->whereBetween('created_at', date_range_filter_transformer($createdAt)))
            ->where('user_id', Auth::id());

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
            return Withdrawal::findOrFail($this->withdrawal_id);
        }) : null;
    }

    public function render()
    {
        return view('livewire.shared.withdrawals.withdrawal-index', [
            'withdrawals' => $this->rows,
            'viewWithdrawal' => $this->view_withdrawal,
        ]);
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function updatingNewWithdrawalWithdrawalType(&$value)
    {
        $value = WithdrawalType::from($value);
    }

    public function create()
    {
        $this->useCachedRows();
        $this->showCreateModal = true;
    }

    public function view(int $withdrawalId)
    {
        $this->useCachedRows();
        $this->withdrawal_id = $withdrawalId;
        $this->showViewModal = true;
    }

    public function save(CreateWithdrawal $createWithdrawal)
    {
        $this->validate();
        $this->newWithdrawal->reference_number = Str::random();
        $createWithdrawal->execute(
            User::where('id', Auth::id())->with('wallet')->firstOrFail(),
            $this->newWithdrawal
        );

        $this->initializeWithdrawal();
        $this->showCreateModal = false;

        $this->dispatchBrowserEvent('notify', ['message' => 'Withdrawal saved!']);
    }

    public function cancel(CancelWithdrawal $cancelWithdrawal, int $withdrawalId)
    {
        $withdrawal = Withdrawal::findOrFail($withdrawalId);

        if ($withdrawal->status !== WithdrawalStatus::Pending) {
            $this->dispatchBrowserEvent('notify', ['message' => 'Unable to cancel this withdrawal!']);

            return;
        }

        $cancelWithdrawal->execute(
            User::where('id', Auth::id())->with('wallet')->firstOrFail(),
            $withdrawal
        );

        $this->showViewModal = false;

        $this->dispatchBrowserEvent('notify', ['message' => 'Withdrawal cancelled!']);
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

    protected function rules(): array
    {
        return [
            'newWithdrawal.amount' => 'required|numeric|min:100',
            'newWithdrawal.withdrawal_type' => ['required', new Enum(WithdrawalType::class)],
            'newWithdrawal.withdrawal_details' => 'required|string',
            'newWithdrawal.user_remarks' => 'sometimes|nullable|string',
        ];
    }

    private function initializeWithdrawal()
    {
        $this->newWithdrawal = WithdrawalData::initialize();
    }
}
