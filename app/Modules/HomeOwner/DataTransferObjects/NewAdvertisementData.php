<?php

namespace App\Modules\HomeOwner\DataTransferObjects;

use App\Modules\HomeOwner\Enums\AdvertisementStatus;
use App\Modules\HomeOwner\Enums\JobPaymentType;
use Carbon\Carbon;
use Livewire\Wireable;
use Spatie\LaravelData\Concerns\WireableData;
use Spatie\LaravelData\Data;

class NewAdvertisementData extends Data implements Wireable
{
    use WireableData;

    public function __construct(
        public ?int $user_id,
        public string $title,
        public string $description,
        public string $address,
        public string $start_date_time,
        public string $end_date_time,
        public JobPaymentType $job_payment_type,
        public float $payment_rate,
        public ?AdvertisementStatus $status
    ) {
    }

    public static function initialize()
    {
        return new self(
            user_id: null,
            title: '',
            description: '',
            address: '',
            start_date_time: Carbon::now()->startOfDay()->toDateTimeString(),
            end_date_time: Carbon::now()->endOfDay()->toDateTimeString(),
            job_payment_type: JobPaymentType::MONTHLY,
            payment_rate: 0.0,
            status: AdvertisementStatus::PENDING,
        );
    }
}
