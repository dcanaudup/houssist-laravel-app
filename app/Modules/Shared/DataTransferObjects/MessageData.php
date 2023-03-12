<?php

namespace App\Modules\Shared\DataTransferObjects;

use Livewire\Wireable;
use Spatie\LaravelData\Concerns\WireableData;
use Spatie\LaravelData\Data;

class MessageData extends Data implements Wireable
{
    use WireableData;

    public function __construct(
        public ?int $chat_id,
        public ?int $message_id,
        public ?int $user_id,
        public string $message,
    ) {
    }

    public static function initialize(): self
    {
        return new self(
            chat_id: null,
            message_id: null,
            user_id: null,
            message: ''
        );
    }
}
