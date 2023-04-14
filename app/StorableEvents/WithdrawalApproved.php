<?php

namespace App\StorableEvents;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class WithdrawalApproved extends ShouldBeStored
{
    public function __construct(
        public string $status,
        public string $admin_remarks
    ){
    }
}
