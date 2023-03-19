<?php

namespace App\Modules\Shared\Actions;

use App\Models\SupportTicketMessage;
use App\Modules\Shared\DataTransferObjects\NewSupportTicketMessageData;

class CreateSupportTicketMessage
{
    public function execute(NewSupportTicketMessageData $newSupportTicketMessageData)
    {
        SupportTicketMessage::create([...$newSupportTicketMessageData->toArray()]);
    }
}
