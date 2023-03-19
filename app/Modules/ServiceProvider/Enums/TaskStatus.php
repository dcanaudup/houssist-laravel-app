<?php

namespace App\Modules\ServiceProvider\Enums;

enum TaskStatus: string
{
    case WAITING = 'waiting';
    case IN_PROGRESS = 'in_progress';
    case COMPLETED = 'completed';
    case PAID = 'paid';
    case DISPUTE = 'dispute';
    case REFUNDED = 'refunded';
    case PAID_DISPUTE = 'paid_dispute';

    public function canBeCompleted(): bool
    {
        return in_array($this, [
            self::WAITING,
            self::IN_PROGRESS,
        ]);
    }
}
