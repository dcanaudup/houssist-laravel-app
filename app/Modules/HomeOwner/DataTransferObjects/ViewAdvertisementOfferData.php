<?php

namespace App\Modules\HomeOwner\DataTransferObjects;

use App\Modules\HomeOwner\Enums\AdvertisementOfferStatus;
use App\Modules\Shared\DataTransferObjects\ViewUserData;
use Carbon\Carbon;
use Livewire\Wireable;
use Spatie\LaravelData\Concerns\WireableData;
use Spatie\LaravelData\Data;

class ViewAdvertisementOfferData extends Data implements Wireable
{
    use WireableData;

    public function __construct(
        public readonly int $advertisement_offer_id,
        public readonly int $advertisement_id,
        public readonly ?float $payment_rate,
        public readonly AdvertisementOfferStatus $status,
        public readonly ViewUserData $service_provider,
        public readonly Carbon $created_at,
        public readonly Carbon $updated_at
    ) {
    }
}
