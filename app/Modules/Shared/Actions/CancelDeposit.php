<?php

namespace App\Modules\Shared\Actions;

use App\Modules\Shared\Enums\DepositStatus;
use App\Modules\Shared\Models\Deposit;

class CancelDeposit
{
    public function execute(Deposit $deposit)
    {
        $deposit->status = DepositStatus::Cancelled;
        $deposit->save();
    }
}
