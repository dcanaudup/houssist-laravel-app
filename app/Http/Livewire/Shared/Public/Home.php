<?php

namespace App\Http\Livewire\Shared\Public;

use Livewire\Component;

class Home extends Component
{
    public function render()
    {
        return view('livewire.shared.public.home')
            ->layout('components.layouts.public');
    }
}
