<?php

namespace App\Modules\Shared\DataTransferObjects;

use Livewire\Wireable;
use Spatie\LaravelData\Concerns\WireableData;
use Spatie\LaravelData\Data;

class NewSupportTicketMessageData extends Data implements Wireable
{
    use WireableData;

    public function __construct(
        public ?int $support_ticket_id,
        public ?int $support_ticket_message_id,
        public ?int $user_id,
        public string $message
    ) {
    }

    public static function initialize(): self
    {
        return new self(
            support_ticket_id: null,
            support_ticket_message_id: null,
            user_id: null,
            message: ''
        );
    }
}
