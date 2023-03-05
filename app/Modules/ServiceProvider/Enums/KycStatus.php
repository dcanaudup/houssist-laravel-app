<?php

namespace App\Modules\ServiceProvider\Enums;

enum KycStatus: string
{
    case Pending = 'pending';
    case Submitted = 'submitted';
    case Processing = 'processing';
    case Approved = 'approved';
    case Rejected = 'rejected';

    public function redirectToWaitingPage(): bool
    {
        if (in_array($this, [self::Submitted, self::Processing])) {
            return true;
        }

        return false;
    }
}
