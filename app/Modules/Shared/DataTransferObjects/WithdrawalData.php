<?php

namespace App\Modules\Shared\DataTransferObjects;

use App\Modules\Shared\Enums\WithdrawalStatus;
use App\Modules\Shared\Enums\WithdrawalType;
use Carbon\Carbon;
use Livewire\Wireable;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\EnumCast;
use Spatie\LaravelData\Concerns\WireableData;
use Spatie\LaravelData\Data;

class WithdrawalData extends Data implements Wireable
{
    use WireableData;

    public function __construct(
        public ?int $withdrawal_id,
        public ?float $amount,
        #[WithCast(EnumCast::class)]
        public ?WithdrawalType $withdrawal_type,
        public ?string $withdrawal_details,
        #[WithCast(EnumCast::class)]
        public WithdrawalStatus $status,
        public ?string $user_remarks,
        public ?string $admin_remarks,
        public ?Carbon $latest_transaction_date,
        public ?string $reference_number
    ) {
    }

    public static function initialize()
    {
        return new self(
            withdrawal_id: null,
            amount: null,
            withdrawal_type: WithdrawalType::Cash,
            withdrawal_details: '',
            status: WithdrawalStatus::Pending,
            user_remarks: '',
            admin_remarks: '',
            latest_transaction_date: null,
            reference_number: null
        );
    }
}
