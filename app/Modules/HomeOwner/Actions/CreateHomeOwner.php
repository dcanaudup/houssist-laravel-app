<?php

namespace App\Modules\HomeOwner\Actions;

use App\Aggregates\WalletAggregateRoot;
use App\Modules\HomeOwner\Models\HomeOwner;
use App\Modules\Shared\DataTransferObjects\UserData;
use Illuminate\Support\Str;
use Silber\Bouncer\BouncerFacade as Bouncer;

class CreateHomeOwner
{
    public function execute(UserData $userData): HomeOwner
    {
        $homeOwner = new HomeOwner();
        $homeOwner->save();
        $user = $homeOwner->user()->create($userData->all());

        $newUuid = Str::uuid()->toString();

        WalletAggregateRoot::retrieve($newUuid)
            ->createWallet($user->id)
            ->persist();
        Bouncer::assign('home-owner')->to($user);

        return $homeOwner;
    }
}
