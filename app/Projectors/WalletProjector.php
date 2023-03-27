<?php

namespace App\Projectors;

use App\Modules\Shared\Models\Deposit;
use App\Modules\Shared\Models\Wallet;
use App\StorableEvents\DepositCancelled;
use App\StorableEvents\DepositCreated;
use App\StorableEvents\WalletCreated;
use Illuminate\Support\Facades\Auth;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class WalletProjector extends Projector
{
    public function onWalletCreated(WalletCreated $event)
    {
        Wallet::create([
            'uuid' => $event->aggregateRootUuid(),
            'user_id' => $event->userId,
        ]);
    }
}
