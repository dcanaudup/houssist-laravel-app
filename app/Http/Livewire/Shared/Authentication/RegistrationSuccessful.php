<?php

namespace App\Http\Livewire\Shared\Authentication;

use Livewire\Component;

class RegistrationSuccessful extends Component
{
    public function render()
    {
        return view('livewire.shared.authentication.registration-successful')
            ->layout('components.layout-authentication');
    }
}
