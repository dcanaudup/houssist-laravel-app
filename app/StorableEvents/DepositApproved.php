<?php

namespace App\StorableEvents;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class DepositApproved extends ShouldBeStored
{
    public function __construct(public string $status, public string $admin_remarks)
    {
    }
}
