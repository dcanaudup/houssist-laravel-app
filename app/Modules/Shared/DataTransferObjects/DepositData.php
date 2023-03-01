<?php

namespace App\Modules\Shared\DataTransferObjects;

use Livewire\Wireable;
use Spatie\LaravelData\Concerns\WireableData;
use Spatie\LaravelData\Data;

class DepositData extends Data implements Wireable
{
    use WireableData;

    public function __construct(
        public ?int $id,
        public ?float $amount,
        public string $deposit_type,
        public string $status,
        public ?string $user_remarks,
        public ?string $admin_remarks,
    ) {
    }
}
