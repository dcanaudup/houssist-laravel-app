<?php

namespace App\Http\Livewire\Shared\Authentication;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public string $email;

    public string $password;

    public bool $remember = false;

    public function render()
    {
        return view('livewire.shared.authentication.login')
            ->layout('components.layouts.auth');
    }

    public function updated($attributeName)
    {
        $this->validateOnly($attributeName);
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

        if (Auth::attempt($credentials, $this->remember)) {
            request()->session()->regenerate();

            return redirect()->intended('/home-owner/dashboard');
        }

        $this->addError('email', 'These credentials do not match any of our records.');
    }
}
