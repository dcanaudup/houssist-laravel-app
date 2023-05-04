<?php

namespace App\Http\Livewire\HomeOwner\General;

use App\Http\Livewire\Traits\WithCachedRows;
use App\Modules\HomeOwner\Enums\AdvertisementStatus;
use App\Modules\ServiceProvider\Enums\TaskStatus;
use Livewire\Component;

class Dashboard extends Component
{
    use WithCachedRows;

    public function getPendingTasksProperty()
    {
        return $this->cache(function () {
            return auth()->user()->home_owner_tasks()->whereIn('status', [TaskStatus::WAITING, TaskStatus::IN_PROGRESS])->count();
        }, 'pending_tasks_');
    }
    public function getOpenAdsProperty()
    {
        return $this->cache(function () {
            return auth()->user()->advertisements()->where('status', AdvertisementStatus::PENDING)->count();
        }, 'open_ads_');
    }

    public function getWalletBalanceProperty()
    {
        return $this->cache(function () {
            return auth()->user()->wallet->balance;
        }, 'wallet_balance_');
    }

    public function render()
    {
        return view('livewire.home-owner.general.dashboard', [
            'walletBalance' => $this->walletBalance,
            'openAds' => $this->openAds,
            'pendingTasks' => $this->pendingTasks,
        ]);
    }
}
