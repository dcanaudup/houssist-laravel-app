<?php

namespace App\Modules\HomeOwner\Enums;

enum AdvertisementOfferStatus: string
{
    case PENDING = 'pending';
    case ACCEPTED = 'accepted';
    case REJECTED = 'rejected';
    case CANCELLED = 'cancelled';
    case USER_CANCELLED = 'user_cancelled';
}
