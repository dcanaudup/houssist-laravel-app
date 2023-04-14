<?php

namespace App\StorableEvents;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class WithdrawalCancelled extends ShouldBeStored
{
    public function __construct(
        public string $status
    ) {
    }
}
