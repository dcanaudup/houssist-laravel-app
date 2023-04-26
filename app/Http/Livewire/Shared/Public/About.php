<?php

namespace App\Http\Livewire\Shared\Public;

use Livewire\Component;

class About extends Component
{
    public function render()
    {
        return view('livewire.shared.public.about')
            ->layout('components.layouts.public');
    }
}
