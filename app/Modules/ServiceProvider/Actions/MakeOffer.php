<?php

namespace App\Modules\ServiceProvider\Actions;

use App\Modules\ServiceProvider\DataTransferObjects\AdvertisementOfferData;
use App\Modules\ServiceProvider\Models\AdvertisementOffer;
use App\Notifications\OfferReceived;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class MakeOffer
{
    public function execute(AdvertisementOfferData $data): AdvertisementOffer
    {
        DB::beginTransaction();
        $offer = AdvertisementOffer::updateOrCreate([
            'advertisement_offer_id' => $data->advertisement_offer_id,
        ],
            [
                ...$data->all(),
            ]);
        DB::commit();

        Notification::send($offer->advertisement->home_owner, new OfferReceived());
        return $offer->refresh();
    }
}
