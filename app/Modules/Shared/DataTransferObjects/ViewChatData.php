<?php

namespace App\Modules\Shared\DataTransferObjects;

use Livewire\Wireable;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Concerns\WireableData;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

class ViewChatData extends Data implements Wireable
{
    use WireableData;

    public function __construct(
        public readonly int $advertisement_id,
        public readonly int $chat_id,
        #[DataCollectionOf(ViewMessageData::class)]
        public readonly DataCollection $messages
    ) {
    }
}
