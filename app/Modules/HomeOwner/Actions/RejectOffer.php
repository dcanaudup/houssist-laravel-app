<?php

namespace App\Modules\HomeOwner\Actions;

use App\Modules\HomeOwner\Enums\AdvertisementOfferStatus;
use App\Modules\ServiceProvider\Models\AdvertisementOffer;
use App\Notifications\OfferRejected;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class RejectOffer
{
    public function execute(int $advertisement_offer_id)
    {
        DB::beginTransaction();
        $advertisementOffer = AdvertisementOffer::where('advertisement_offer_id', $advertisement_offer_id)
            ->with('service_provider')
            ->firstOrFail();
        $advertisementOffer->status = AdvertisementOfferStatus::REJECTED;
        $advertisementOffer->save();
        DB::commit();

        Notification::send($advertisementOffer->service_provider, new OfferRejected());
    }
}
