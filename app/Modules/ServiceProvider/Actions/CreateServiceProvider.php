<?php

namespace App\Modules\ServiceProvider\Actions;

use App\Modules\ServiceProvider\Models\ServiceProvider;
use App\Modules\Shared\DataTransferObjects\UserData;

class CreateServiceProvider
{
    public function execute(UserData $userData)
    {
        $serviceProvider = new ServiceProvider();
        $serviceProvider->save();
        $serviceProvider->user()->create($userData->all());
    }
}
