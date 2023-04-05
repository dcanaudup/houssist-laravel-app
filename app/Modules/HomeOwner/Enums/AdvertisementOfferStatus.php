<?php

namespace App\Modules\HomeOwner\Enums;

use Illuminate\Contracts\Support\DeferringDisplayableValue;

enum AdvertisementOfferStatus: string implements DeferringDisplayableValue
{
    case PENDING = 'pending';
    case ACCEPTED = 'accepted';
    case REJECTED = 'rejected';
    case ACCEPTED_OTHER_OFFER = 'accepted_other_offer';
    case CANCELLED = 'cancelled';
    case USER_CANCELLED = 'user_cancelled';

    public function resolveDisplayableValue()
    {
        return match ($this) {
            self::PENDING => __('Pending'),
            self::ACCEPTED => __('Accepted'),
            self::REJECTED => __('Rejected'),
            self::ACCEPTED_OTHER_OFFER => __('Accepted other offer'),
            self::CANCELLED => __('Cancelled'),
            self::USER_CANCELLED => __('User cancelled'),
        };
    }
}
