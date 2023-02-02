<?php

namespace App\Http\Controllers\HomeOwner;

use App\Http\Controllers\Controller;
use App\Modules\HomeOwner\Actions\CreateHomeOwner;
use App\Modules\Shared\DataTransferObjects\UserData;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function __construct(private CreateHomeOwner $createHomeOwner)
    {
    }

    public function create()
    {
        return view('home-owner.registration.create');
    }

    public function store(UserData $userData, Request $request)
    {
        $this->createHomeOwner->execute($userData);

        return redirect('/');
    }
}
