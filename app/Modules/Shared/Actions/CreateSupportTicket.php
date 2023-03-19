<?php

namespace App\Modules\Shared\Actions;

use App\Modules\Shared\DataTransferObjects\NewSupportTicketData;
use App\Modules\Shared\Models\SupportTicket;

class CreateSupportTicket
{
    public function execute(NewSupportTicketData $data)
    {
        $supportTicket = SupportTicket::create([...$data->toArray()]);
        $data->message->user_id = $data->user_id;

        $supportTicket->messages()->create([...$data->message->toArray()]);
    }
}
