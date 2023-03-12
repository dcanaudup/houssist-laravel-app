<?php

namespace App\Modules\Shared\DataTransferObjects;

use Illuminate\Support\Carbon;
use Livewire\Wireable;
use Spatie\LaravelData\Concerns\WireableData;
use Spatie\LaravelData\Data;

class ViewMessageData extends Data implements Wireable
{
    use WireableData;

    public function __construct(
        public readonly int $chat_id,
        public readonly int $message_id,
        public readonly int $user_id,
        public readonly string $message,
        public readonly Carbon $created_at,
        public readonly Carbon $updated_at
    ) {
    }
}
