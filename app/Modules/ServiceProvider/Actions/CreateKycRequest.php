<?php

namespace App\Modules\ServiceProvider\Actions;

use App\Modules\ServiceProvider\DataTransferObjects\KycRequestData;
use App\Modules\ServiceProvider\Enums\KycStatus;
use App\Modules\ServiceProvider\Models\KycRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateKycRequest
{
    public function execute(KycRequestData $kycRequestData): KycRequest
    {
        DB::beginTransaction();
        $kycRequest = KycRequest::updateOrCreate(
            [
                'id' => $kycRequestData->id,
            ],
            [
                'user_id' => Auth::id(),
                'valid_id_number' => $kycRequestData->valid_id_number,
                'user_remarks' => $kycRequestData->user_remarks,
                'status' => KycStatus::Submitted,
            ]
        );

        $kycRequest->addMedia($kycRequestData->valid_id)->toMediaCollection('kyc.valid_id');
        $kycRequest->addMedia($kycRequestData->selfie)->toMediaCollection('kyc.selfie');
        $kycRequest->addMedia($kycRequestData->nbi_clearance)->toMediaCollection('kyc.nbi_clearance');

        if ($kycRequestData->supporting_documents) {
            $kycRequest->addMedia($kycRequestData->supporting_documents)->toMediaCollection('kyc.supporting_documents');
        }

        Auth::user()->update([
            'name' => $kycRequestData->name,
            'mobile_number' => $kycRequestData->mobile_number,
            'address' => $kycRequestData->address,
        ]);

        DB::commit();

        return $kycRequest;
    }
}
