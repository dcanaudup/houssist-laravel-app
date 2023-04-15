<?php

namespace App\Modules\Shared\Enums;

enum SupportTicketInFavor: string
{
    case HomeOwner = 'home_owner';
    case ServiceProvider = 'service_provider';
}
