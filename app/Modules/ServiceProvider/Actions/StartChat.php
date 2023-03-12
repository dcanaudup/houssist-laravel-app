<?php

namespace App\Modules\ServiceProvider\Actions;

use App\Modules\Shared\DataTransferObjects\ChatData;
use App\Modules\Shared\Models\Chat;

class StartChat
{
    public function execute(ChatData $chatData): Chat
    {
        $chat = Chat::create([
            'advertisement_id' => $chatData->advertisement_id,
        ]);

        return $chat->refresh();
    }
}
