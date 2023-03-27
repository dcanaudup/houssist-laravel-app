<?php

namespace App\Modules\Shared\Enums;

enum DepositStatus: string
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
}
