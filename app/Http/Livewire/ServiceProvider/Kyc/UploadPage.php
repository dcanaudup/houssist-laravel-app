<?php

namespace App\Http\Livewire\ServiceProvider\Kyc;

use App\Modules\ServiceProvider\Actions\CreateKycRequest;
use App\Modules\ServiceProvider\DataTransferObjects\KycRequestData;
use Livewire\Component;
use Livewire\WithFileUploads;

class UploadPage extends Component
{
    use WithFileUploads;

    public $name;

    public $address;

    public $mobile_number;

    public $valid_id;

    public $valid_id_number;

    public $selfie;

    public $nbi_clearance;

    public $supporting_documents;

    public $user_remarks;

    protected $rules = [
        'name' => 'required|string|max:255',
        'address' => 'required|string|max:255',
        'mobile_number' => 'required|string|max:255',
        'valid_id' => 'required|file|mimes:jpeg,png,jpg,pdf|max:2048',
        'valid_id_number' => 'required|string|max:255',
        'selfie' => 'required|file|mimes:jpeg,png,jpg,pdf|max:2048',
        'nbi_clearance' => 'required|file|mimes:jpeg,png,jpg,pdf|max:2048',
        'supporting_documents' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
        'user_remarks' => 'nullable|string|max:255',
    ];

    public function mount()
    {
        $this->name = auth()->user()->name;
    }

    public function render()
    {
        return view('livewire.service-provider.kyc.upload-page');
    }

    public function save(CreateKycRequest $createKycRequest)
    {
        $this->validate();

        $createKycRequest->execute(new KycRequestData(
            id: null,
            name: $this->name,
            mobile_number: $this->mobile_number,
            address: $this->address,
            valid_id: $this->valid_id,
            valid_id_number: $this->valid_id_number,
            selfie: $this->selfie,
            nbi_clearance: $this->nbi_clearance,
            supporting_documents: $this->supporting_documents,
            user_remarks: $this->user_remarks
        ));

        return redirect()->route('service-provider.kyc.waiting');
    }
}
