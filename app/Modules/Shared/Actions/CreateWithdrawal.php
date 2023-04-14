<?php

namespace App\Modules\Shared\Actions;

use App\Aggregates\WalletAggregateRoot;
use App\Aggregates\WithdrawalAggregateRoot;
use App\Modules\Shared\DataTransferObjects\WithdrawalData;
use App\Modules\Shared\Enums\WalletTransactionType;
use App\Modules\Shared\Models\User;
use Illuminate\Support\Str;

class CreateWithdrawal
{
    public function execute(User $user, WithdrawalData $withdrawalData)
    {
        $newUuid = Str::uuid()->toString();
        WalletAggregateRoot::retrieve($user->wallet->uuid)
            ->subtractMoney(
                $withdrawalData->amount,
                WalletTransactionType::Withdrawal->value,
                $withdrawalData->reference_number
            )
            ->persist();

        WithdrawalAggregateRoot::retrieve($newUuid)
            ->createWithdrawal($user->id, $withdrawalData)
            ->persist();
    }
}
