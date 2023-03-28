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

    public function addMoney(float $amount, string $transactionType, string $referenceNumber, string $remarks = '')
    {
        $this->recordThat(new MoneyAdded($amount, $transactionType, $referenceNumber, $remarks));

        return $this;
    }

    public function applyMoneyAdded(MoneyAdded $event)
    {
        $this->balance += $event->amount;
    }
}
