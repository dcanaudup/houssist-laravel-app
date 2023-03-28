<?php

namespace App\StorableEvents;

use App\Modules\Shared\DataTransferObjects\DepositData;
use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class DepositCreated extends ShouldBeStored
{
    public function __construct(
        public int $user_id,
        public string $deposit_type,
        public float $amount,
        public string $status,
        public string $user_remarks,
        public string $admin_remarks,
        public array $attachments,
        public string $reference_number
    ) {
    }
}
