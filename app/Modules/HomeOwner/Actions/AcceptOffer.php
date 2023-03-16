<?php

namespace App\Modules\HomeOwner\Actions;

use App\Modules\HomeOwner\Enums\AdvertisementOfferStatus;
use App\Modules\HomeOwner\Enums\AdvertisementStatus;
use App\Modules\ServiceProvider\Enums\TaskStatus;
use App\Modules\ServiceProvider\Models\AdvertisementOffer;
use App\Modules\ServiceProvider\Models\Task;
use App\Modules\Shared\Models\Advertisement;
use Illuminate\Support\Facades\DB;

class AcceptOffer
{
    public function execute(
        int $advertisement_id,
        int $advertisement_offer_id
    ) {
        DB::beginTransaction();
        $advertisement = Advertisement::findOrFail($advertisement_id);
        $advertisementOffer = AdvertisementOffer::findOrFail($advertisement_offer_id);

        $this->updateAdvertisement($advertisement, $advertisementOffer);

        $this->updateAdvertisementOffer($advertisementOffer);

        $this->createTask($advertisement, $advertisementOffer);

        $this->rejectOtherOffers($advertisementOffer);
        DB::commit();
    }

    private function updateAdvertisement(Advertisement $advertisement, AdvertisementOffer $advertisementOffer)
    {
        $advertisement->status = AdvertisementStatus::ACCEPTED;
        $advertisement->accepted_offer_id = $advertisementOffer->advertisement_offer_id;
        $advertisement->save();
    }

    private function updateAdvertisementOffer(AdvertisementOffer $advertisementOffer)
    {
        $advertisementOffer->acceptance_date = now();
        $advertisementOffer->status = AdvertisementStatus::ACCEPTED;
        $advertisementOffer->save();
    }

    private function rejectOtherOffers(AdvertisementOffer $advertisementOffer)
    {
        AdvertisementOffer::where('advertisement_id', $advertisementOffer->advertisement_id)
            ->where('advertisement_offer_id', '!=', $advertisementOffer->advertisement_offer_id)
            ->update(['status' => AdvertisementOfferStatus::ACCEPTED_OTHER_OFFER]);
    }

    private function createTask(Advertisement $advertisement, AdvertisementOffer $advertisementOffer)
    {
        $task = new Task();
        $task->service_provider_id = $advertisementOffer->user_id;
        $task->home_owner_id = $advertisement->user_id;
        $task->advertisement_id = $advertisement->advertisement_id;
        $task->advertisement_offer_id = $advertisementOffer->advertisement_offer_id;
        $task->status = TaskStatus::WAITING;
        $task->save();
    }
}
