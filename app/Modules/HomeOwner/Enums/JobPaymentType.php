<?php

namespace App\Modules\HomeOwner\Enums;

enum JobPaymentType: string
{
    case MONTHLY = 'monthly';
    case DAILY = 'daily';
    case HOURLY = 'hourly';
    case FIXED = 'fixed';
}
