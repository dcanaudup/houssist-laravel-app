<?php

namespace App\Modules\HomeOwner\Actions;

use App\Aggregates\WalletAggregateRoot;
use App\Modules\HomeOwner\Enums\AdvertisementStatus;
use App\Modules\HomeOwner\Enums\PaymentMethod;
use App\Modules\Shared\Enums\WalletTransactionType;
use App\Modules\Shared\Models\Advertisement;
use App\Modules\Shared\Models\User;
use Illuminate\Support\Str;

class CancelAdvertisement
{
    public function execute(Advertisement $advertisement, User $user)
    {
        $advertisement->update([
            'status' => AdvertisementStatus::CANCELLED,
        ]);

        if ($advertisement->payment_method === PaymentMethod::WALLET) {
            WalletAggregateRoot::retrieve($user->wallet->uuid)
                ->addMoney(
                    CalculateTotalAmount::calculateTotalPayment($advertisement),
                    WalletTransactionType::Ad_Cancelled->value,
                    Str::uuid()->toString()
                )
                ->persist();
        }
    }
}
