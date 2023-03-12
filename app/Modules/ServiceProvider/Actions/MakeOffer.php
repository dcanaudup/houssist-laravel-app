<?php

namespace App\Modules\ServiceProvider\Actions;

use App\Models\AdvertisementOffer;
use App\Modules\ServiceProvider\DataTransferObjects\AdvertisementOfferData;
use Illuminate\Support\Facades\DB;

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

        return $offer->refresh();
    }
}
