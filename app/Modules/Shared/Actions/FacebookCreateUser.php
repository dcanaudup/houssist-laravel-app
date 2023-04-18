<?php

namespace App\Modules\Shared\Actions;

use App\Aggregates\WalletAggregateRoot;
use App\Modules\HomeOwner\Models\HomeOwner;
use App\Modules\ServiceProvider\Models\ServiceProvider;
use App\Modules\Shared\DataTransferObjects\UserData;
use Illuminate\Support\Str;
use Silber\Bouncer\BouncerFacade as Bouncer;

class FacebookCreateUser
{
    private const USER_TYPE_MAP = [
        'home_owner' => [
            'model' => HomeOwner::class,
            'role' => 'home-owner'
        ],
        'service_provider' => [
            'model' => ServiceProvider::class,
            'role' => 'service-provider'
        ]
    ];

    public function execute(UserData $userData, string $userType)
    {
        $userTypeModel = new (self::USER_TYPE_MAP[$userType]['model']);
        $userTypeModel->save();
        $userFields = $userData->all() + [
            'facebook_id' => session()->get('facebook_id'),
        ];
        $user = $userTypeModel->user()->create($userFields);

        $newUuid = Str::uuid()->toString();

        WalletAggregateRoot::retrieve($newUuid)
            ->createWallet($user->id)
            ->persist();

        Bouncer::assign(self::USER_TYPE_MAP[$userType]['role'])->to($user);

        return $userTypeModel;
    }
}
