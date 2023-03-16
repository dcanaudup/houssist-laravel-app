<?php

namespace App\Modules\Shared\Actions;

use App\Modules\Shared\DataTransferObjects\MessageData;
use App\Modules\Shared\Models\Message;

class SendMessage
{
    public function execute(MessageData $data): Message
    {
        return Message::create($data->all());
    }
}
