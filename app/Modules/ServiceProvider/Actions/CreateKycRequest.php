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

        $kycRequest->addMediaFromDisk($kycRequestData->valid_id->getRealPath())->toMediaCollection('kyc.valid_id');
        $kycRequest->addMediaFromDisk($kycRequestData->selfie->getRealPath())->toMediaCollection('kyc.selfie');
        $kycRequest->addMediaFromDisk($kycRequestData->nbi_clearance->getRealPath())->toMediaCollection('kyc.nbi_clearance');

        if ($kycRequestData->supporting_documents) {
            $kycRequest->addMediaFromDisk($kycRequestData->supporting_documents->getRealPath())->toMediaCollection('kyc.supporting_documents');
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
