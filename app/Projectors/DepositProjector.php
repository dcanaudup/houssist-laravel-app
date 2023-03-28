<?php

namespace App\Projectors;

use App\Modules\Shared\Enums\DepositStatus;
use App\Modules\Shared\Models\Deposit;
use App\StorableEvents\DepositApproved;
use App\StorableEvents\DepositCancelled;
use App\StorableEvents\DepositCreated;
use App\StorableEvents\DepositRejected;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class DepositProjector extends Projector
{
    public function onDepositCreated(DepositCreated $event)
    {
        $deposit = Deposit::create([
            'uuid' => $event->aggregateRootUuid(),
            'user_id' => $event->user_id,
            'deposit_type' => $event->deposit_type,
            'amount' => $event->amount,
            'status' => $event->status,
            'user_remarks' => $event->user_remarks,
            'admin_remarks' => $event->admin_remarks,
            'latest_transaction_date' => now(),
            'reference_number' => $event->reference_number,
        ]);
        Media::whereIn('uuid', $event->attachments)
            ->update([
                'model_id' => $deposit->deposit_id,
                'model_type' => Deposit::class,
            ]);
    }

    public function onDepositCancelled(DepositCancelled $event)
    {
        Deposit::where('uuid', $event->aggregateRootUuid())
            ->update([
                'status' => DepositStatus::Cancelled,
            ]);
    }

    public function onDepositApproved(DepositApproved $event)
    {
        Deposit::where('uuid', $event->aggregateRootUuid())
            ->update([
                'status' => DepositStatus::Approved,
            ]);
    }

    public function onDepositRejected(DepositRejected $event)
    {
        Deposit::where('uuid', $event->aggregateRootUuid())
            ->update([
                'status' => DepositStatus::Rejected,
            ]);
    }
}
