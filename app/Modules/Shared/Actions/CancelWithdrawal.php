<?php

namespace App\Modules\Shared\Actions;

use App\Aggregates\WalletAggregateRoot;
use App\Aggregates\WithdrawalAggregateRoot;
use App\Models\Withdrawal;
use App\Modules\Shared\Enums\WalletTransactionType;
use App\Modules\Shared\Models\User;
use Illuminate\Support\Facades\Auth;

class CancelWithdrawal
{
    public function execute(User $user, Withdrawal $withdrawal)
    {
        WalletAggregateRoot::retrieve($user->wallet->uuid)
            ->addMoney(
                $withdrawal->amount,
                WalletTransactionType::Withdrawal_Cancelled->value,
                $withdrawal->reference_number
            )
            ->persist();

        WithdrawalAggregateRoot::retrieve($withdrawal->uuid)
            ->cancelWithdrawal($user->id, $withdrawal->withdrawal_id)
            ->persist();
    }
}
