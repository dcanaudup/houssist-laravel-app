<?php

namespace App\Modules\Shared\DataTransferObjects;

use Livewire\Wireable;
use Spatie\LaravelData\Concerns\WireableData;
use Spatie\LaravelData\Data;

class ChatData extends Data implements Wireable
{
    use WireableData;

    public function __construct(
        public ?int $advertisement_id,
        public ?int $chat_id,
        public ?int $advertisement_offer_id
    ) {
    }

    public static function initialize(): self
    {
        return new self(
            advertisement_id: null,
            chat_id: null,
            advertisement_offer_id: null
        );
    }
}
