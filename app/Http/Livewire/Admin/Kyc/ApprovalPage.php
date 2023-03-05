<?php

namespace App\Http\Livewire\Admin\Kyc;

use App\Modules\ServiceProvider\Models\KycRequest;
use Livewire\Component;

class ApprovalPage extends Component
{
    public function render()
    {
        return view('livewire.admin.kyc.approval-page', [
            'kycRequests' => KycRequest::query()
            ->with(['media', 'user'])
            ->paginate(10)
        ]);
    }
}
