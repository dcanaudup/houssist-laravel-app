<?php

namespace App\Http\Livewire\ServiceProvider\Authentication;

use App\Modules\ServiceProvider\Actions\CreateServiceProvider;
use App\Modules\Shared\DataTransferObjects\UserData;
use Livewire\Component;

class Registration extends Component
{
    public UserData $user;

    protected $rules = [
        'user.email' => ['required', 'email', 'unique:users,email'],
        'user.password' => ['required', 'min:8'],
    ];

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
        $this->validate();

        $createServiceProvider->execute($this->user);

        return redirect('/');
    }
}
