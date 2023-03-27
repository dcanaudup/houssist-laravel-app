<?php

namespace App\StorableEvents;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class DepositCancelled extends ShouldBeStored
{
    public function __construct(public int $deposit_id, public string $status)
    {
    }
}
