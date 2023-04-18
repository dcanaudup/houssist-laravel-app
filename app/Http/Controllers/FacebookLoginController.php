<?php

namespace App\Http\Controllers;

use App\Modules\Shared\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class FacebookLoginController extends Controller
{
    public function auth(Request $request)
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function callback(Request $request)
    {
        $socialiteUser = Socialite::driver('facebook')->user();

        if (!$user = User::where('facebook_id', $socialiteUser->id)->first()) {
            session()->put('facebook_name', $socialiteUser->name);
            session()->put('facebook_email', $socialiteUser->email);
            session()->put('facebook_id', $socialiteUser->id);

            return redirect()->route('facebook.register');
        }

        Auth::login($user, true);

        return redirect()->route($user->userable->dashboard_link);
    }

    public function register()
    {

    }
}
