<?php

namespace App\Modules\ServiceProvider\Actions;

use App\Modules\Shared\DataTransferObjects\ChatData;
use App\Modules\Shared\Models\Chat;

class StartChat
{
    public function execute(ChatData $chatData): Chat
    {
        $chat = Chat::create([
            ...$chatData->all(),
        ]);

        return $chat->refresh();
    }
}
