<?php

namespace App\Http\Livewire\HomeOwner\Authentication;

use App\Modules\HomeOwner\Actions\CreateHomeOwner;
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
        return view('livewire.home-owner.authentication.register')
            ->layout('components.layout-authentication');
    }

    public function submit(CreateHomeOwner $createHomeOwner)
    {
        $this->validate();

        $createHomeOwner->execute($this->user);

        return redirect('/');
    }
}
