<?php

namespace App\Modules\Shared\Enums;

enum SupportTicketStatus: string
{
    case Open = 'open';
    case Closed = 'closed';
}
