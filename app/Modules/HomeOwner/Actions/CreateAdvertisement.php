<?php

namespace App\Modules\HomeOwner\Actions;

use App\Modules\HomeOwner\DataTransferObjects\NewAdvertisementData;
use App\Modules\Shared\Models\Advertisement;
use Illuminate\Support\Facades\DB;

class CreateAdvertisement
{
    public function execute(NewAdvertisementData $newAdvertisement): Advertisement
    {
        DB::beginTransaction();
        $advertisement = new Advertisement($newAdvertisement->toArray());
        $advertisement->save();

        $advertisement->addMedia($newAdvertisement->featured)
            ->toMediaCollection('advertisement-featured');

        foreach ($newAdvertisement->attachments as $attachment) {
            $advertisement->addMedia($attachment)
                ->toMediaCollection('advertisement-attachments');
        }

        DB::commit();

        return $advertisement;
    }
}
