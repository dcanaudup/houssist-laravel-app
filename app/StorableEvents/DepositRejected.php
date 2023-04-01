<?php

namespace App\StorableEvents;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class DepositRejected extends ShouldBeStored
{
    public function __construct(public string $status, public string $admin_remarks)
    {
    }
}
