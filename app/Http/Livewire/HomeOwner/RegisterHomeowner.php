<?php

namespace App\Http\Livewire\HomeOwner;

use App\Modules\HomeOwner\Actions\CreateHomeOwner;
use App\Modules\Shared\DataTransferObjects\UserData;
use Livewire\Component;

class RegisterHomeowner extends Component
{
    public UserData $user;

    public function mount()
    {
        $this->user = new UserData(null, "", "");
    }

    public function render()
    {
        return view('livewire.home-owner.register-homeowner');
    }

    public function submit(CreateHomeOwner $createHomeOwner)
    {
        $createHomeOwner->execute($this->user);

        return redirect('/');
    }
}
