<?php

namespace App\Aggregates;

use App\Modules\Shared\DataTransferObjects\DepositData;
use App\Modules\Shared\Enums\DepositStatus;
use App\StorableEvents\DepositApproved;
use App\StorableEvents\DepositCancelled;
use App\StorableEvents\DepositCreated;
use App\StorableEvents\DepositRejected;
use DomainException;
use Illuminate\Support\Str;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class DepositAggregateRoot extends AggregateRoot
{
    protected DepositStatus $status;

    public function createDeposit(int $userId, DepositData $depositData, array $attachments)
    {
        $depositCreated = $depositData->only('deposit_type', 'amount', 'status', 'user_remarks', 'admin_remarks')->toArray();
        $depositCreated['user_id'] = $userId;
        $depositCreated['attachments'] = $attachments;
        $depositCreated['reference_number'] = Str::random();
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
        $this->recordThat(new DepositCancelled($this->status->value));

        return $this;
    }

    public function applyDepositCancelled(DepositCancelled $event)
    {
        if (! DepositStatus::canBeCancelled($event->status)) {
            throw new DomainException('Deposit cannot be cancelled.');
        }

        $this->status = DepositStatus::Cancelled;
    }

    public function approveDeposit()
    {
        $this->recordThat(new DepositApproved($this->status->value));

        return $this;
    }

    public function applyDepositApproved(DepositApproved $event)
    {
        if (! DepositStatus::canBeApproved($event->status)) {
            throw new DomainException('Deposit cannot be approved.');
        }

        $this->status = DepositStatus::Approved;
    }

    public function rejectDeposit()
    {
        $this->recordThat(new DepositRejected($this->status->value));

        return $this;
    }

    public function applyDepositRejected(DepositRejected $event)
    {
        if (! DepositStatus::canBeApproved($event->status)) {
            throw new DomainException('Deposit cannot be rejected.');
        }

        $this->status = DepositStatus::Rejected;
    }
}
