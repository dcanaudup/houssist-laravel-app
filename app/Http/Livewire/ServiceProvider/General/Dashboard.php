<?php

namespace App\Http\Livewire\ServiceProvider\General;

use App\Http\Livewire\Traits\WithCachedRows;
use App\Modules\HomeOwner\Enums\AdvertisementOfferStatus;
use App\Modules\HomeOwner\Enums\AdvertisementStatus;
use App\Modules\ServiceProvider\Enums\TaskStatus;
use Livewire\Component;

class Dashboard extends Component
{
    use WithCachedRows;

    public function getPendingTasksProperty()
    {
        return $this->cache(function () {
            return auth()->user()->service_provider_tasks()->whereIn('status', [TaskStatus::WAITING, TaskStatus::IN_PROGRESS])->count();
        }, 'pending_tasks_');
    }

    public function getOpenOffersProperty()
    {
        return $this->cache(function () {
            return auth()->user()->advertisement_offers()->where('status', AdvertisementOfferStatus::PENDING)->count();
        }, 'open_offers_');
    }

    public function getWalletBalanceProperty()
    {
        return $this->cache(function () {
            return auth()->user()->wallet->balance;
        }, 'wallet_balance_');
    }

    public function render()
    {
        return view('livewire.service-provider.general.dashboard', [
            'walletBalance' => $this->walletBalance,
            'openOffers' => $this->openOffers,
            'pendingTasks' => $this->pendingTasks,
        ]);
    }
}
