<?php

namespace App\Modules\HomeOwner\Actions;

use App\Modules\HomeOwner\Models\HomeOwner;
use App\Modules\Shared\DataTransferObjects\UserData;
use App\Modules\Shared\Models\User;

class CreateHomeOwner
{
    public function execute(UserData $userData)
    {
        $homeOwner = new HomeOwner();
        $homeOwner->save();
        $homeOwner->user()->create($userData->all());

    }
}
