<?php

namespace App\StorableEvents;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class WithdrawalCreated extends ShouldBeStored
{
    public function __construct(
        public int $user_id,
        public string $withdrawal_type,
        public string $withdrawal_details,
        public float $amount,
        public string $status,
        public string $user_remarks,
        public string $admin_remarks,
        public string $reference_number
    ) {
    }
}
