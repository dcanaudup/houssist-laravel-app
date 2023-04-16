<?php

namespace App\Http\Livewire\Shared\Wallet;

use App\Http\Livewire\Traits\WithCachedRows;
use App\Http\Livewire\Traits\WithLockedPublicPropertiesTrait;
use App\Http\Livewire\Traits\WithPerPagination;
use App\Http\Livewire\Traits\WithSorting;
use App\Models\Withdrawal;
use App\Modules\Shared\Models\WalletTransaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class TransactionsIndex extends Component
{
    use WithCachedRows, WithPerPagination, WithSorting, WithLockedPublicPropertiesTrait;

    public $showFilters = false;

    public $filters = [
        'transaction_type' => null,
        'created_at' => null,
    ];

    protected $queryString = ['filters', 'sorts'];

    public $showViewModal = false;

    /** @locked */
    public $wallet_transaction_id;

    public function getRowsQueryProperty()
    {
        $query = WalletTransaction::query()
            ->when($this->filters['transaction_type'] ?? null, fn ($query, $transactionType) => $query->where('transaction_type', $transactionType))
            ->when($this->filters['created_at'] ?? null, fn ($query, $createdAt) => $query->whereBetween('created_at', date_range_filter_transformer($createdAt)))
            ->where('wallet_id', Auth::user()->wallet->id);

        return $this->applySorting($query);
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function getViewWalletTransactionProperty()
    {
        return $this->wallet_transaction_id ? Cache::remember(WalletTransaction::CACHE_KEY.$this->wallet_transaction_id, 300, function () {
            return WalletTransaction::findOrFail($this->wallet_transaction_id);
        }) : null;
    }

    public function render()
    {
        return view('livewire.shared.wallet.transactions-index', [
            'walletTransactions' => $this->rows,
            'viewWalletTransaction' => $this->viewWalletTransaction,
        ]);
    }

    public function view(int $walletTransactionId)
    {
        $this->useCachedRows();
        $this->wallet_transaction_id = $walletTransactionId;
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
}
