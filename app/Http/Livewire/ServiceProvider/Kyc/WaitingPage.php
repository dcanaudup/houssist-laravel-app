<?php

namespace App\Http\Livewire\ServiceProvider\Kyc;

use App\Modules\ServiceProvider\Models\KycRequest;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class WaitingPage extends Component
{
    public function render()
    {
        return view('livewire.service-provider.kyc.waiting-page', [
            'kycRequest' => KycRequest::where('user_id', Auth::id())
                ->with(['media', 'user'])
                ->firstOrFail(),
        ]);
    }
}
