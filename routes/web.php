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

Route::get('/', Home::class)
    ->name('home.index');

Route::group(['middleware' => ['guest']], function () {
    Route::get('/home-owner/register', HomeOwnerRegistration::class)
        ->name('home-owner.registration.create');
    Route::get('/service-provider/register', ServiceProviderRegistration::class)
        ->name('service-provider.registration.create');
    Route::get('/login', Login::class)
        ->name('login');
    Route::get('/registration-successful', \App\Http\Livewire\Shared\Authentication\RegistrationSuccessful::class)
        ->name('registration-successful');
});

Route::group(['middleware' => ['auth', 'verified'], 'prefix' => 'home-owner'], function () {
    Route::get('/dashboard', \App\Http\Livewire\HomeOwner\General\Dashboard::class)
        ->name('home-owner.dashboard');
    Route::get('/advertisements', \App\Http\Livewire\HomeOwner\Advertisement\AdvertisementIndex::class)
        ->name('home-owner.advertisements');
    Route::get('/advertisements/{advertisement}', \App\Http\Livewire\HomeOwner\Advertisement\AdvertisementShow::class)
        ->name('home-owner.advertisements.show');
    Route::get('/advertisements/{advertisement}/offers/{offer:advertisement_id}', \App\Http\Livewire\HomeOwner\Advertisement\AdvertisementOffers::class)
        ->name('home-owner.advertisements.offer');
});

Route::group(['middleware' => ['auth', 'verified'], 'prefix' => 'service-provider'], function () {
    Route::group(['middleware' => 'check_kyc'], function () {
        Route::get('/dashboard', \App\Http\Livewire\ServiceProvider\General\Dashboard::class)
            ->name('service-provider.dashboard');
    });

    Route::get('/kyc', \App\Http\Livewire\ServiceProvider\Kyc\UploadPage::class)
        ->name('service-provider.kyc.create');
    Route::get('/kyc/waiting', \App\Http\Livewire\ServiceProvider\Kyc\WaitingPage::class)
        ->name('service-provider.kyc.waiting');
});

Route::group(['middleware' => ['auth', 'verified'], 'prefix' => 'admin'], function () {
    Route::get('/kyc/approvals', \App\Http\Livewire\Admin\Kyc\ApprovalPage::class)
        ->name('admin.kyc.approvals');
});

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/deposits', \App\Http\Livewire\Shared\Deposits\DepositPage::class)
        ->name('shared.deposits');
});
