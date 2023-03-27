<?php

namespace App\Modules\ServiceProvider\Actions;

use App\Aggregates\WalletAggregateRoot;
use App\Modules\ServiceProvider\Models\ServiceProvider;
use App\Modules\Shared\DataTransferObjects\UserData;
use Illuminate\Support\Str;

class CreateServiceProvider
{
    public function execute(UserData $userData)
    {
        $serviceProvider = new ServiceProvider();
        $serviceProvider->save();
        $user = $serviceProvider->user()->create($userData->all());

        $newUuid = Str::uuid()->toString();

        WalletAggregateRoot::retrieve($newUuid)
            ->createWallet($user->id)
            ->persist();

        return $serviceProvider;
    }
}
