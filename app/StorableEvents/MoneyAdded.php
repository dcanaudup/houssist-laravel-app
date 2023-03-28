<?php

namespace App\StorableEvents;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class MoneyAdded extends ShouldBeStored
{
    public function __construct(
        public float $amount,
        public string $transactionType,
        public string $referenceNumber,
        public string $remarks = ''
    ) {
    }
}
