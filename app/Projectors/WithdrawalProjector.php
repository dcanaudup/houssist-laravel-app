<?php

namespace App\Projectors;

use App\Models\Withdrawal;
use App\Modules\Shared\Enums\WithdrawalStatus;
use App\StorableEvents\WithdrawalApproved;
use App\StorableEvents\WithdrawalCancelled;
use App\StorableEvents\WithdrawalCreated;
use App\StorableEvents\WithdrawalRejected;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class WithdrawalProjector extends Projector
{
    public function onWithdrawalCreated(WithdrawalCreated $event)
    {
        Withdrawal::create([
            'uuid' => $event->aggregateRootUuid(),
            'user_id' => $event->user_id,
            'withdrawal_type' => $event->withdrawal_type,
            'withdrawal_details' => $event->withdrawal_details,
            'amount' => $event->amount,
            'status' => $event->status,
            'user_remarks' => $event->user_remarks,
            'admin_remarks' => $event->admin_remarks,
            'latest_transaction_date' => now(),
            'reference_number' => $event->reference_number,
        ]);
    }

    public function onWithdrawalCancelled(WithdrawalCancelled $event)
    {
        Withdrawal::where('uuid', $event->aggregateRootUuid())->update([
            'status' => WithdrawalStatus::Cancelled,
            'latest_transaction_date' => now(),
        ]);
    }

    public function onWithdrawalApproved(WithdrawalApproved $event)
    {
        Withdrawal::where('uuid', $event->aggregateRootUuid())->update([
            'status' => WithdrawalStatus::Approved,
            'admin_remarks' => $event->admin_remarks,
            'latest_transaction_date' => now(),
        ]);
    }

    public function onWithdrawalRejected(WithdrawalRejected $event)
    {
        Withdrawal::where('uuid', $event->aggregateRootUuid())->update([
            'status' => WithdrawalStatus::Rejected,
            'admin_remarks' => $event->admin_remarks,
            'latest_transaction_date' => now(),
        ]);
    }
}
