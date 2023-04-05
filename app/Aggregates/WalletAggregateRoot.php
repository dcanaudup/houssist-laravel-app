<?php

namespace App\Aggregates;

use App\Exceptions\NotEnoughBalanceException;
use App\StorableEvents\MoneyAdded;
use App\StorableEvents\MoneySubtracted;
use App\StorableEvents\WalletCreated;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class WalletAggregateRoot extends AggregateRoot
{
    public float $balance = 0;

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

    public function subtractMoney(
        float $amount,
        string $transactionType,
        string $referenceNumber
    ) {
        if ($amount > $this->balance) {
            throw new NotEnoughBalanceException();
        }

        $this->recordThat(new MoneySubtracted($amount, $transactionType, $referenceNumber));

        return $this;
    }

    public function applyMoneySubtracted(MoneySubtracted $event)
    {
        $this->balance -= $event->amount;
    }
}
