<?php

namespace BinaryCats\LaravelTenant\Providers;

use BinaryCats\LaravelTenant\TenantManager;
use Illuminate\Support\ServiceProvider;

class TenantManagerServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            TenantManager::class, function () {
                return new TenantManager();
            }
        );
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
