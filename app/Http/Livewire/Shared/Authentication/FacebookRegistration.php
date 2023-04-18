<?php

namespace App\Http\Livewire\Shared\Authentication;

use App\Modules\Shared\Actions\FacebookCreateUser;
use App\Modules\Shared\DataTransferObjects\UserData;
use Illuminate\Support\Str;
use Livewire\Component;

class FacebookRegistration extends Component
{
    public $username;

    public $user_type = 'service_provider';

    public function render()
    {
        return view('livewire.shared.authentication.facebook-registration')
            ->layout('components.layouts.auth');
    }

    protected function rules()
    {
        return [
            'username' => ['required', 'min:6', 'unique:users,username'],
            'user_type' => ['required', 'in:home_owner,service_provider'],
        ];
    }

    public function submit(FacebookCreateUser $facebookCreateUser)
    {
        $this->validate();

        $userData = new UserData(
            null,
            username: $this->username,
            email: session()->get('facebook_email'),
            password: bcrypt(Str::random(8)),
            name: session()->get('facebook_name'),
            email_verified_at: now(),
        );

        $facebookCreateUser->execute($userData, $this->user_type);

        return redirect()->route('facebook.registration-successful');
    }
}
