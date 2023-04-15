<?php

namespace App\Modules\Admin\Actions;

use App\Aggregates\WalletAggregateRoot;
use App\Modules\ServiceProvider\Enums\TaskStatus;
use App\Modules\Shared\Enums\SupportTicketInFavor;
use App\Modules\Shared\Enums\SupportTicketStatus;
use App\Modules\Shared\Enums\WalletTransactionType;
use App\Modules\Shared\Models\SupportTicket;
use App\Modules\Shared\Models\User;
use Illuminate\Support\Str;

class CloseForHomeOwner
{
    public function execute(SupportTicket $supportTicket, User $user)
    {
        $supportTicket->update([
            'in_favor_of' => SupportTicketInFavor::HomeOwner,
            'status' => SupportTicketStatus::Closed,
            'closed_by' => auth()->id(),
        ]);

        $supportTicket->task()->update([
            'status' => TaskStatus::REFUNDED,
        ]);

        WalletAggregateRoot::retrieve($user->wallet->uuid)
            ->addMoney(
                $supportTicket->task->advertisement_offer->payment_rate,
                WalletTransactionType::Dispute_Refund->value,
                Str::random(),
                'Dispute refund for Task #' . $supportTicket->task->task_id
            )
            ->persist();
    }
}
