<?php

namespace App\Aggregates;

use App\Modules\Shared\DataTransferObjects\DepositData;
use App\Modules\Shared\Enums\DepositStatus;
use App\Modules\Shared\Models\Deposit;
use App\StorableEvents\DepositCancelled;
use App\StorableEvents\DepositCreated;
use DomainException;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class DepositAggregateRoot extends AggregateRoot
{
    protected DepositStatus $status;

    public function createDeposit(int $userId, DepositData $depositData, array $attachments)
    {
        $depositCreated = $depositData->only( 'deposit_type', 'amount', 'status', 'user_remarks', 'admin_remarks')->toArray();
        $depositCreated['user_id'] = $userId;
        $depositCreated['attachments'] = $attachments;
        $this->recordThat(new DepositCreated(
            ...$depositCreated
        ));

        return $this;
    }

    public function applyDepositCreated(DepositCreated $event)
    {
        $this->status = DepositStatus::Pending;
    }

    public function cancelDeposit(int $deposit_id)
    {
        $this->recordThat(new DepositCancelled($deposit_id, $this->status->value));

        return $this;
    }

    public function applyDepositCancelled(DepositCancelled $event)
    {
        if (!DepositStatus::canBeCancelled($event->status)) {
            throw new DomainException('Deposit cannot be cancelled.');
        }

        $this->status = DepositStatus::Cancelled;
    }
}
