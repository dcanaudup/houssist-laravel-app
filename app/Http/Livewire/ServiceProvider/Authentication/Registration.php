<?php

namespace App\Http\Livewire\ServiceProvider\Authentication;

use App\Modules\ServiceProvider\Actions\CreateServiceProvider;
use App\Modules\Shared\DataTransferObjects\UserData;
use Livewire\Component;

class Registration extends Component
{
    public UserData $user;

    public function mount()
    {
        $this->user = new UserData(null, '', '');
    }

    public function render()
    {
        return view('livewire.service-provider.authentication.register')
            ->layout('components.layout-authentication');
    }

    public function submit(CreateServiceProvider $createServiceProvider)
    {
        $createServiceProvider->execute($this->user);

        return redirect('/');
    }
}
