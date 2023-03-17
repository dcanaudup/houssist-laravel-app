<?php

namespace App\Modules\Shared\DataTransferObjects;

use Illuminate\Support\Carbon;
use Livewire\Wireable;
use Spatie\LaravelData\Concerns\WireableData;
use Spatie\LaravelData\Data;

class ViewUserData extends Data implements Wireable
{
    use WireableData;

    public function __construct(
        public readonly int $id,
        public readonly string $username,
        public readonly string $name,
        public readonly string $email,
        public readonly int $userable_id,
        public readonly string $userable_type,
        public readonly string $address,
        public readonly ?Carbon $birthday,
        public readonly string $mobile_number
    ) {
    }
}
