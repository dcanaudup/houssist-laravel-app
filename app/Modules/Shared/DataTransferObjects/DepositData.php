<?php

namespace App\Modules\Shared\DataTransferObjects;

use App\Modules\Shared\Enums\DepositStatus;
use App\Modules\Shared\Enums\DepositType;
use App\Modules\Shared\Models\Deposit;
use Carbon\Carbon;
use Livewire\Wireable;
use Spatie\LaravelData\Concerns\WireableData;
use Spatie\LaravelData\Data;

class DepositData extends Data implements Wireable
{
    use WireableData;

    public function __construct(
        public ?int $id,
        public ?float $amount,
        public ?DepositType $deposit_type,
        public DepositStatus $status,
        public ?string $user_remarks,
        public ?string $admin_remarks,
        public ?Carbon $latest_transaction_date
    ) {
    }

    public static function initialize()
    {
        return new self(
            id: null,
            amount: null,
            deposit_type: null,
            status: DepositStatus::Pending,
            user_remarks: '',
            admin_remarks: '',
            latest_transaction_date: null
        );
    }
}
