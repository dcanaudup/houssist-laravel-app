<?php

namespace App\Modules\ServiceProvider\DataTransferObjects;

use App\Modules\ServiceProvider\Enums\KycStatus;
use Illuminate\Http\UploadedFile;
use Livewire\Wireable;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\EnumCast;
use Spatie\LaravelData\Concerns\WireableData;
use Spatie\LaravelData\Data;

class KycRequestData extends Data implements Wireable
{
    use WireableData;

    public function __construct(
        public ?int $id,
        public string $name,
        public string $mobile_number,
        public string $address,
        public ?UploadedFile $valid_id,
        public string $valid_id_number,
        public ?UploadedFile $selfie,
        public ?UploadedFile $nbi_clearance,
        public ?UploadedFile $supporting_documents,
        #[WithCast(EnumCast::class)]
        public KycStatus $status = KycStatus::Pending,
        public ?int $user_id = null,
        public ?string $user_remarks = null,
        public ?string $admin_remarks = null
    ) {
    }

    public static function initialize()
    {
        return new self(
            id: null,
            name: '',
            mobile_number: '',
            address: '',
            valid_id: null,
            valid_id_number: '',
            selfie: null,
            nbi_clearance: null,
            supporting_documents: null,
            status: KycStatus::Pending,
            user_id: null,
            user_remarks: null,
            admin_remarks: null
        );
    }
}
