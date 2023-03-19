<?php

namespace App\Http\Livewire\Admin\Kyc;

use App\Http\Livewire\Traits\WithCachedRows;
use App\Http\Livewire\Traits\WithPerPagination;
use App\Modules\Admin\Actions\UpdateKycRequestStatus;
use App\Modules\Admin\DataTransferObjects\UpdateKycRequestData;
use App\Modules\ServiceProvider\Enums\KycStatus;
use App\Modules\ServiceProvider\Models\KycRequest;
use Illuminate\Validation\Rules\Enum;
use Livewire\Component;

class ApprovalPage extends Component
{
    use WithCachedRows, WithPerPagination;

    public $showViewModal = false;

    public KycRequest $viewKycRequest;

    public UpdateKycRequestData $updateKycRequestData;

    public function getRowsQueryProperty()
    {
        return KycRequest::query()
            ->with(['media', 'user']);
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function render()
    {
        return view('livewire.admin.kyc.approval-page', [
            'kycRequests' => $this->rows,
        ]);
    }

    public function updatingUpdateKycRequestDataStatus(&$value)
    {
        $value = KycStatus::from($value);
    }

    protected function rules(): array
    {
        return [
            'updateKycRequestData.admin_remarks' => 'nullable|string|max:255',
            'updateKycRequestData.status' => ['required', new Enum(KycStatus::class)],
        ];
    }

    public function view(KycRequest $kycRequest)
    {
        $this->useCachedRows();
        $this->viewKycRequest = $kycRequest;
        $this->updateKycRequestData = new UpdateKycRequestData($kycRequest->admin_remarks, $kycRequest->status);
        $this->showViewModal = true;
    }

    public function submit(UpdateKycRequestStatus $updateKycRequestStatus)
    {
        $this->validate();

        $updateKycRequestStatus->execute($this->viewKycRequest, $this->updateKycRequestData);

        $this->dispatchBrowserEvent('notify', ['message' => 'KYC Request status updated!']);
        $this->showViewModal = false;
    }
}
