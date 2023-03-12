<?php

namespace App\Modules\HomeOwner\Actions;

use App\Modules\HomeOwner\DataTransferObjects\NewAdvertisementData;
use App\Modules\Shared\Models\Advertisement;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class CreateAdvertisement
{
    public function execute(NewAdvertisementData $newAdvertisement, ?UploadedFile $attachments): Advertisement
    {
        DB::beginTransaction();
        $advertisement = new Advertisement($newAdvertisement->toArray());
        $advertisement->save();

        if ($attachments) {
            $advertisement->addMedia($attachments)
                ->toMediaCollection('advertisement');
        }

        DB::commit();

        return $advertisement;
    }
}
