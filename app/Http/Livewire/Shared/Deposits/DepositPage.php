<?php

namespace App\Http\Livewire\Shared\Deposits;

use App\Aggregates\DepositAggregateRoot;
use App\Http\Livewire\Traits\WithCachedRows;
use App\Http\Livewire\Traits\WithPerPagination;
use App\Models\TempUpload;
use App\Modules\Shared\DataTransferObjects\DepositData;
use App\Modules\Shared\Enums\DepositStatus;
use App\Modules\Shared\Enums\DepositType;
use App\Modules\Shared\Models\Deposit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Http\Livewire\Traits\WithSorting;

class DepositPage extends Component
{
    use WithFileUploads, WithCachedRows, WithPerPagination, WithSorting;

    public $showFilters = false;

    public $filters = [
        'deposit_type' => null,
        'created_at' => null,
    ];

    protected $listeners = ['refreshComponent' => '$refresh'];

    protected $queryString = ['filters', 'sorts'];

    public $showCreateModal = false;

    public $showViewModal = false;

    public DepositData $newDeposit;

    public Deposit $viewDeposit;

    public $attachments;

    protected function rules(): array
    {
        return [
            'newDeposit.amount' => 'required|numeric|min:100',
            'newDeposit.deposit_type' => 'required|in:cash,bank_transaction,gcash,maya',
            'newDeposit.user_remarks' => 'sometimes|nullable|string',
            'attachments' => 'required|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ];
    }

    public function mount()
    {
        $this->initializeDeposit();
    }

    public function getRowsQueryProperty()
    {
        $query = Deposit::query()
            ->when($this->filters['deposit_type'] ?? null, fn($query, $depositType) => $query->where('deposit_type', $depositType))
            ->when($this->filters['created_at'] ?? null, fn($query, $createdAt) => $query->whereBetween('created_at', date_range_filter_transformer($createdAt)))
            ->where('user_id', Auth::id())
            ->with('media');

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
        return view('livewire.shared.deposits.deposit', [
            'deposits' => $this->rows,
        ]);
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function updatingNewDepositDepositType(&$value)
    {
        $value = DepositType::from($value);
    }

    protected function initializeDeposit()
    {
        $this->newDeposit = DepositData::initialize();
        if ($this->attachments) {
            $this->removeUpload('attachments', $this->attachments);
            $this->attachments = null;
        }
    }

    public function create()
    {
        $this->showCreateModal = true;
    }

    public function view(int $depositId)
    {
        $this->viewDeposit = Deposit::findOrFail($depositId);
        $this->showViewModal = true;
    }

    public function save()
    {
        $this->validate();
        $newUuid = Str::uuid()->toString();
        $attachments = TempUpload::first()->addMediaFromDisk($this->attachments)->toMediaCollection('deposits');

        DepositAggregateRoot::retrieve($newUuid)
            ->createDeposit(Auth::id(), $this->newDeposit, [$attachments->uuid])
            ->persist();

        $this->initializeDeposit();
        $this->showCreateModal = false;
        $this->dispatchBrowserEvent('pond-reset');

        $this->dispatchBrowserEvent('notify', ['message' => 'Deposit saved!']);
    }

    public function cancel(int $deposit_id)
    {
        $deposit = Deposit::findOrFail($deposit_id);

        if ($deposit->status != DepositStatus::Pending) {
            $this->dispatchBrowserEvent('notify', ['message' => 'Unable to cancel this deposit!']);

            return;
        }

        DepositAggregateRoot::retrieve($deposit->uuid)
            ->cancelDeposit($deposit->deposit_id)
            ->persist();

        $this->showViewModal = false;

        $this->dispatchBrowserEvent('notify', ['message' => 'Deposit cancelled!']);
    }

    public function toggleShowFilters()
    {
        $this->useCachedRows();

        $this->showFilters = ! $this->showFilters;
    }

    public function resetFilters() { $this->reset('filters'); }
}
