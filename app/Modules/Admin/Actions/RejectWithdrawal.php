<?php

namespace App\Modules\Admin\Actions;

use App\Aggregates\WalletAggregateRoot;
use App\Aggregates\WithdrawalAggregateRoot;
use App\Models\Withdrawal;
use App\Modules\Shared\Enums\WalletTransactionType;
use App\Notifications\WithdrawalRejected;
use Illuminate\Support\Facades\Notification;

class RejectWithdrawal
{
    public function execute(Withdrawal $withdrawal, string $admin_remarks)
    {
        WithdrawalAggregateRoot::retrieve($withdrawal->uuid)
            ->rejectWithdrawal($admin_remarks)
            ->persist();

        WalletAggregateRoot::retrieve($withdrawal->user->wallet->uuid)
            ->addMoney(
                $withdrawal->amount,
                WalletTransactionType::Withdrawal_Rejected->value,
                $withdrawal->reference_number,
                $admin_remarks
            )
            ->persist();

        Notification::send($withdrawal->user, new WithdrawalRejected());
    }
}
