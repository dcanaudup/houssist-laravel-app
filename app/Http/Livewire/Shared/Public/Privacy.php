<?php

namespace App\Http\Livewire\Shared\Public;

use Livewire\Component;

class Privacy extends Component
{
    public function render()
    {
        return view('livewire.shared.public.privacy')
            ->layout('components.layouts.public');
    }
}
