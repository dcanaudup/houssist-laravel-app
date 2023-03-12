<?php

namespace App\Modules\HomeOwner\DataTransferObjects;

use App\Modules\HomeOwner\Enums\AdvertisementStatus;
use App\Modules\HomeOwner\Enums\JobPaymentType;
use Carbon\Carbon;
use Livewire\Wireable;
use Spatie\LaravelData\Concerns\WireableData;
use Spatie\LaravelData\Data;

class ViewAdvertisementData extends Data implements Wireable
{
    use WireableData;

    public function __construct(
        public readonly int $advertisement_id,
        public readonly string $title,
        public readonly string $description,
        public readonly string $address,
        public readonly Carbon $start_date_time,
        public readonly Carbon $end_date_time,
        public readonly JobPaymentType $job_payment_type,
        public readonly float $payment_rate,
        public readonly AdvertisementStatus $status
    ) {
    }
}
