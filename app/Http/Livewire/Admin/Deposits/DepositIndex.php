<?php

namespace App\Http\Livewire\Admin\Deposits;

use App\Aggregates\DepositAggregateRoot;
use App\Aggregates\WalletAggregateRoot;
use App\Http\Livewire\Traits\WithCachedRows;
use App\Http\Livewire\Traits\WithLockedPublicPropertiesTrait;
use App\Http\Livewire\Traits\WithPerPagination;
use App\Modules\Shared\Enums\WalletTransactionType;
use App\Modules\Shared\Models\Deposit;
use Livewire\Component;

class DepositIndex extends Component
{
    use WithPerPagination, WithCachedRows, WithLockedPublicPropertiesTrait;

    public $showViewModal = false;

    /** @locked */
    public Deposit $viewDeposit;

    public function getRowsQueryProperty()
    {
        return Deposit::query()
            ->with('user');
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function render()
    {
        return view('livewire.admin.deposits.deposit-index', [
            'deposits' => $this->rows,
        ]);
    }

    public function view(int $depositId)
    {
        $this->useCachedRows();
        $this->viewDeposit = Deposit::query()
            ->with('user')
            ->where('deposit_id', $depositId)
            ->firstOrFail();
        $this->showViewModal = true;
    }

    public function approve(int $depositId)
    {
        $deposit = Deposit::query()
            ->where('deposit_id', $depositId)
            ->first();

        $wallet = auth()->user()->wallet;

        DepositAggregateRoot::retrieve($deposit->uuid)
            ->approveDeposit()
            ->persist();

        WalletAggregateRoot::retrieve($wallet->uuid)
            ->addMoney($deposit->amount, WalletTransactionType::Deposit->value, $deposit->reference_number, 'Deposit Successful')
            ->persist();

        $this->showViewModal = false;

        $this->dispatchBrowserEvent('notify', ['message' => 'Deposit approved.']);
    }

    public function reject(int $depositId)
    {
        $deposit = Deposit::query()
            ->where('deposit_id', $depositId)
            ->first();

        DepositAggregateRoot::retrieve($deposit->uuid)
            ->rejectDeposit()
            ->persist();

        $this->showViewModal = false;

        $this->dispatchBrowserEvent('notify', ['message' => 'Deposit rejected.']);
    }
}
