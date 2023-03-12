<?php

namespace App\Modules\HomeOwner\Enums;

enum AdvertisementStatus: string
{
    case PENDING = 'pending';
    case ACCEPTED = 'accepted';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';
}
