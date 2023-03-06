<?php

namespace App\Modules\Admin\Actions;

use App\Modules\Admin\DataTransferObjects\UpdateKycRequestData;
use App\Modules\ServiceProvider\Models\KycRequest;

class UpdateKycRequestStatus
{
    public function execute(KycRequest $kycRequest, UpdateKycRequestData $updateKycRequestData)
    {
        $kycRequest->update([
            'admin_remarks' => $updateKycRequestData->admin_remarks,
            'status' => $updateKycRequestData->status,
        ]);
    }
}
