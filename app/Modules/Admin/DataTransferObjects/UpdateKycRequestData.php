<?php

namespace App\Modules\Admin\DataTransferObjects;

use App\Modules\ServiceProvider\Enums\KycStatus;
use Livewire\Wireable;
use Spatie\LaravelData\Concerns\WireableData;
use Spatie\LaravelData\Data;

class UpdateKycRequestData extends Data implements Wireable
{
    use WireableData;

    public function __construct(
        public ?string $admin_remarks,
        public KycStatus $status
    ) {
    }
}
