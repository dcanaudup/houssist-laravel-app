<?php

namespace App\Modules\Admin\Actions;

use App\Aggregates\WalletAggregateRoot;
use App\Aggregates\WithdrawalAggregateRoot;
use App\Models\Withdrawal;
use App\Modules\Shared\Models\User;
use App\Notifications\WithdrawalApproved;
use Illuminate\Support\Facades\Notification;

class ApproveWithdrawal
{
    public function execute(Withdrawal $withdrawal, string $admin_remarks)
    {
        WithdrawalAggregateRoot::retrieve($withdrawal->uuid)
            ->approveWithdrawal($admin_remarks)
            ->persist();

        Notification::send($withdrawal->user, new WithdrawalApproved());
    }
}
