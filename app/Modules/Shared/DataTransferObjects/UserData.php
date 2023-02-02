<?php

namespace App\Modules\Shared\DataTransferObjects;

use Carbon\Carbon;
use Livewire\Wireable;
use Spatie\LaravelData\Concerns\WireableData;
use Spatie\LaravelData\Data;
class UserData extends Data implements Wireable
{
    use WireableData;

    public function __construct(
        public ?int $id,
        public string $email,
        public string $password,
        public string $name = "",
        public string $address = "",
        public ?Carbon $birth_date = null,
        public ?Carbon $email_verified_at = null,
        public ?string $remember_token = null
    ) {
    }

}
