<?php

namespace App\Modules\HomeOwner\Actions;

use App\Modules\HomeOwner\Enums\AdvertisementOfferStatus;
use App\Modules\ServiceProvider\Models\AdvertisementOffer;
use Illuminate\Support\Facades\DB;

class RejectOffer
{
    public function execute(int $advertisement_offer_id)
    {
        DB::beginTransaction();
        $advertisementOffer = AdvertisementOffer::findOrFail($advertisement_offer_id);
        $advertisementOffer->status = AdvertisementOfferStatus::REJECTED;
        $advertisementOffer->save();
        DB::commit();
    }
}
