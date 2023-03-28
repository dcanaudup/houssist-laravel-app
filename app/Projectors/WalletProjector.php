<?php

namespace App\Projectors;

use App\Modules\Shared\Enums\WalletTransactionType;
use App\Modules\Shared\Models\Deposit;
use App\Modules\Shared\Models\Wallet;
use App\Modules\Shared\Models\WalletTransaction;
use App\StorableEvents\DepositCancelled;
use App\StorableEvents\DepositCreated;
use App\StorableEvents\MoneyAdded;
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

    public function onMoneyAdded(MoneyAdded $event)
    {
        $wallet = Wallet::where('uuid', $event->aggregateRootUuid())->first();
        $wallet->balance = $wallet->balance + $event->amount * 100;
        $wallet->save();

        WalletTransaction::create([
            'wallet_id' => $wallet->id,
            'amount' => $event->amount * 100,
            'transaction_type' => $event->transactionType,
            'reference_number' => $event->referenceNumber,
            'remarks' => $event->remarks,
        ]);
    }
}
