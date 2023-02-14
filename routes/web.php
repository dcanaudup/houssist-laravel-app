<?php

use App\Http\Livewire\HomeOwner\Authentication\Registration as HomeOwnerRegistration;
use App\Http\Livewire\ServiceProvider\Authentication\Registration as ServiceProviderRegistration;
use App\Http\Livewire\Shared\Authentication\Login;
use App\Http\Livewire\Shared\Public\Home;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('/', Home::class)
    ->name('home.index');
Route::get('/home-owner/register', HomeOwnerRegistration::class)
    ->name('home-owner.registration.create');
Route::get('/service-provider/register', ServiceProviderRegistration::class)
    ->name('service-provider.registration.create');
Route::get('/login', Login::class)
    ->name('login');
Route::get('/registration-successful', \App\Http\Livewire\Shared\Authentication\RegistrationSuccessful::class);
Route::group(['middleware' => ['auth', 'verified'], 'prefix' => 'home-owner'], function () {
    Route::get('/dashboard', \App\Http\Livewire\HomeOwner\General\Dashboard::class);
});
