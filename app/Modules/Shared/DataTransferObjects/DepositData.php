<?php

namespace App\Modules\Shared\DataTransferObjects;

use App\Modules\Shared\Enums\DepositStatus;
use App\Modules\Shared\Enums\DepositType;
use Carbon\Carbon;
use Livewire\Wireable;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\EnumCast;
use Spatie\LaravelData\Concerns\WireableData;
use Spatie\LaravelData\Data;

class DepositData extends Data implements Wireable
{
    use WireableData;

    public function __construct(
        public ?int $deposit_id,
        public ?float $amount,
        #[WithCast(EnumCast::class)]
        public ?DepositType $deposit_type,
        #[WithCast(EnumCast::class)]
        public DepositStatus $status,
        public ?string $user_remarks,
        public ?string $admin_remarks,
        public ?Carbon $latest_transaction_date
    ) {
    }

    public static function initialize()
    {
        return new self(
            deposit_id: null,
            amount: null,
            deposit_type: DepositType::Cash,
            status: DepositStatus::Pending,
            user_remarks: '',
            admin_remarks: '',
            latest_transaction_date: null
        );
    }
}
