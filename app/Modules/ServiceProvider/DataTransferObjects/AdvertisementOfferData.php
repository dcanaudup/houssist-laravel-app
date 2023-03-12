<?php

namespace App\Modules\ServiceProvider\DataTransferObjects;

use App\Modules\HomeOwner\Enums\AdvertisementOfferStatus;
use Illuminate\Support\Carbon;
use Livewire\Wireable;
use Spatie\LaravelData\Concerns\WireableData;
use Spatie\LaravelData\Data;

class AdvertisementOfferData extends Data implements Wireable
{
    use WireableData;

    public function __construct(
        public ?int $user_id,
        public ?int $advertisement_offer_id,
        public ?int $advertisement_id,
        public ?float $payment_rate,
        public ?Carbon $offer_date,
        public AdvertisementOfferStatus $status
    ) {
    }

    public static function initialize(): self
    {
        return new self(
            user_id: null,
            advertisement_offer_id: null,
            advertisement_id: null,
            payment_rate: null,
            offer_date: null,
            status: AdvertisementOfferStatus::PENDING
        );
    }
}
