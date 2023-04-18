<?php

namespace App\Http\Livewire\Shared\Authentication;

use Livewire\Component;

class FacebookRegistrationSuccessful extends Component
{
    public function render()
    {
        return view('livewire.shared.authentication.facebook-registration-successful')
            ->layout('components.layouts.public');
    }
}
