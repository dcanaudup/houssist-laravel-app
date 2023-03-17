<?php

namespace App\Http\Livewire\HomeOwner\Authentication;

use App\Modules\HomeOwner\Actions\CreateHomeOwner;
use App\Modules\Shared\DataTransferObjects\UserData;
use App\Modules\Shared\Models\User;
use Livewire\Component;

class Registration extends Component
{
    public UserData $user;

    protected $rules = [
        'user.username' => ['required', 'min:6', 'unique:users,username'],
        'user.email' => ['required', 'email', 'unique:users,email'],
        'user.password' => ['required', 'min:8'],
    ];

    public function mount()
    {
        $this->user = new UserData(null, '', '', '');
    }

    public function render()
    {
        return view('livewire.home-owner.authentication.register')
            ->layout('components.layouts.auth');
    }

    public function submit(CreateHomeOwner $createHomeOwner)
    {
        $this->validate();

        $homeOwner = $createHomeOwner->execute($this->user);

        /** @var User */
        $homeOwner->user->sendEmailVerificationNotification();

        return redirect()->route('registration-successful');
    }
}
