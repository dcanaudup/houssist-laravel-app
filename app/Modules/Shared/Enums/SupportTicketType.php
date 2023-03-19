<?php

namespace App\Modules\Shared\Enums;

enum SupportTicketType: string
{
    case GENERAL = 'general';
    case TASK_DISPUTE = 'task_dispute';
}
