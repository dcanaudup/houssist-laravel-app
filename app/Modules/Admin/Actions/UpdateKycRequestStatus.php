<?php

namespace App\Modules\Admin\Actions;

use App\Modules\Admin\DataTransferObjects\UpdateKycRequestData;
use App\Modules\ServiceProvider\Enums\KycStatus;
use App\Modules\ServiceProvider\Models\KycRequest;
use App\Notifications\KycApproved;
use Illuminate\Support\Facades\Notification;

class UpdateKycRequestStatus
{
    public function execute(KycRequest $kycRequest, UpdateKycRequestData $updateKycRequestData)
    {
        $kycRequest->update([
            'admin_remarks' => $updateKycRequestData->admin_remarks,
            'status' => $updateKycRequestData->status,
        ]);

        if ($updateKycRequestData->status === KycStatus::Approved) {
            Notification::send($kycRequest->user, new KycApproved());
        }
    }
}
