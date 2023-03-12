<?php

namespace App\Modules\Shared\Actions;

use App\Models\Message;
use App\Modules\Shared\DataTransferObjects\MessageData;

class SendMessage
{
    public function execute(MessageData $data): Message
    {
        return Message::create($data->all());
    }
}
