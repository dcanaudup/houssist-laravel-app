<?php

namespace App\Http\Livewire\ServiceProvider\Authentication;

use App\Modules\ServiceProvider\Actions\CreateServiceProvider;
use App\Modules\Shared\DataTransferObjects\UserData;
use App\Modules\Shared\Models\User;
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
        $this->user = new UserData(null, '', '', '');
    }

    public function render()
    {
        return view('livewire.service-provider.authentication.register')
            ->layout('components.layouts.auth');
    }

    public function submit(CreateServiceProvider $createServiceProvider)
    {
        $this->validate();

        $serviceProvider = $createServiceProvider->execute($this->user);

        /** @var User */
        $serviceProvider->user->sendEmailVerificationNotification();

        return redirect()->route('registration-successful');
    }
}
