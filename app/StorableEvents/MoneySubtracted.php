<?php

namespace App\StorableEvents;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class MoneySubtracted extends ShouldBeStored
{
    public function __construct(
        public float $amount,
        public string $transactionType,
        public string $referenceNumber
    ) {
    }
}
