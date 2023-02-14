<?php

namespace App\Http\Livewire\Shared\Authentication;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public $email;
    public $password;

    public function render()
    {
        return view('livewire.shared.authentication.login')
            ->layout('components.layout-authentication');
    }

    public function rules()
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ];
    }

    public function submit()
    {
        $credentials = $this->validate();

        if (Auth::attempt($credentials)) {
            request()->session()->regenerate();

            return redirect()->intended('/home-owner/dashboard');
        }
    }
}
