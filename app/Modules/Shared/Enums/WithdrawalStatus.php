<?php

namespace App\Modules\Shared\Enums;

enum WithdrawalStatus: string
{
    case Pending = 'pending';
    case Processing = 'processing';
    case Approved = 'approved';
    case Rejected = 'rejected';
    case Cancelled = 'cancelled';

    public static function canBeCancelled(string $status): bool
    {
        return $status == self::Pending->value;
    }

    public static function canBeApproved(string $status): bool
    {
        return self::canBeCancelled($status);
    }

    public static function canBeRejected(string $status): bool
    {
        return self::canBeCancelled($status);
    }
}
