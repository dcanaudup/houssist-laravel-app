<?php

namespace App\Aggregates;

use App\Modules\Shared\DataTransferObjects\DepositData;
use App\StorableEvents\DepositCancelled;
use App\StorableEvents\DepositCreated;
use App\StorableEvents\MoneyAdded;
use App\StorableEvents\WalletCreated;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class WalletAggregateRoot extends AggregateRoot
{
    protected int $balance = 0;

    public function createWallet(string $userId)
    {
        $this->recordThat(new WalletCreated($userId));

        return $this;
    }

    public function addMoney(int $amount)
    {
        $this->recordThat(new MoneyAdded($amount));

        return $this;
    }

    public function applyMoneyAdded(MoneyAdded $event)
    {
        $this->balance += $event->amount;
    }
}
