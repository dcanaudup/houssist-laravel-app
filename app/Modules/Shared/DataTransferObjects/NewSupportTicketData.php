<?php

namespace App\Modules\Shared\DataTransferObjects;

use App\Modules\Shared\Enums\SupportTicketStatus;
use App\Modules\Shared\Enums\SupportTicketType;
use Livewire\Wireable;
use Spatie\LaravelData\Concerns\WireableData;
use Spatie\LaravelData\Data;

class NewSupportTicketData extends Data implements Wireable
{
    use WireableData;

    public function __construct(
        public ?int $user_id,
        public ?int $support_ticket_id,
        public ?int $task_id,
        public string $subject,
        public ?string $reference_number,
        public SupportTicketType $support_ticket_type,
        public SupportTicketStatus $status,
        public NewSupportTicketMessageData $message,
        public array $attachments
    ) {
    }

    public static function initialize()
    {
        return new self(
            user_id: null,
            support_ticket_id: null,
            task_id: null,
            subject: '',
            reference_number: generate_reference_number('support_tickets'),
            support_ticket_type: SupportTicketType::GENERAL,
            status: SupportTicketStatus::Open,
            message: NewSupportTicketMessageData::initialize(),
            attachments: [],
        );
    }
}
