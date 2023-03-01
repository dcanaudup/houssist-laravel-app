<?php

namespace App\Modules\Shared\Actions;

use App\Modules\Shared\DataTransferObjects\DepositData;
use App\Modules\Shared\Models\Deposit;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateDeposit
{
    public function execute(DepositData $depositData, UploadedFile $attachments): Deposit
    {
        DB::beginTransaction();
        $deposit = Deposit::updateOrCreate([
            'id' => $depositData->id,
        ],
            [
                ...$depositData->all(),
                'user_id' => Auth::id(),
                'status' => 'pending',
                'latest_transaction_date' => now(),
            ]);

        $deposit->addMedia($attachments)
            ->toMediaCollection('deposits');

        DB::commit();

        return $deposit;
    }
}
