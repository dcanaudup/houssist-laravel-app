<?php

namespace App\Http\Livewire\Shared\Public;

use Livewire\Component;

class Terms extends Component
{
    public function render()
    {
        return view('livewire.shared.public.terms')
            ->layout('components.layouts.public');
    }
}
