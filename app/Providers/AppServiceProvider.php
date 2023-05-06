<?php

namespace App\Providers;

use App\Http\Livewire\Shared\Authentication\Login;
use App\Modules\Shared\ValueObject\FacebookEnabled;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->when(FacebookEnabled::class)
            ->needs('$enabled')
            ->give(config('services.facebook.enabled', false));
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
