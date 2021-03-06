<?php

namespace BinaryCats\LaravelTenant\Providers;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\ServiceProvider;

class BlueprintMacros extends ServiceProvider
{
    /**
     * List new methods for Blade compiler.
     *
     * @var array
     */
    protected $methods = [
        'tenant',
    ];

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        foreach ($this->methods as $directive) {
            $this->{$directive}();
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // void
    }

    /**
     * Add a tenant directive to Blueprint.
     *
     * @return void
     */
    public function tenant()
    {
        Blueprint::macro(
            'tenant', function () {
                return $this->integer(config('tenant.foreign_key'))->unsigned()->index();
            }
        );
    }
}
