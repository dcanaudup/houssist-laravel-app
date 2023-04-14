<?php

namespace App\Aggregates;

use App\Modules\Shared\Enums\WithdrawalStatus;
use App\StorableEvents\WithdrawalCancelled;
use App\StorableEvents\WithdrawalCreated;
use DomainException;
use Illuminate\Support\Str;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class WithdrawalAggregateRoot extends AggregateRoot
{
    protected WithdrawalStatus $currentStatus;

    public function createWithdrawal($userId, $withdrawalData): static
    {
        $withdrawalCreated = $withdrawalData->only('withdrawal_type', 'amount', 'status', 'withdrawal_details', 'user_remarks', 'admin_remarks')->toArray();
        $withdrawalCreated['user_id'] = $userId;
        $withdrawalCreated['reference_number'] = Str::random();
        $this->recordThat(new WithdrawalCreated(
            ...$withdrawalCreated
        ));

        return $this;
    }

    public function applyWithdrawalCreated(WithdrawalCreated $event)
    {
        $this->currentStatus = WithdrawalStatus::Pending;
    }

    public function cancelWithdrawal(): static
    {
        $this->recordThat(new WithdrawalCancelled($this->currentStatus->value));

        return $this;
    }

    public function applyWithdrawalCancelled(WithdrawalCancelled $event)
    {
        if (! WithdrawalStatus::canBeCancelled($event->status)) {
            throw new DomainException('Withdrawal cannot be cancelled.');
        }

        $this->currentStatus = WithdrawalStatus::Cancelled;
    }
}
