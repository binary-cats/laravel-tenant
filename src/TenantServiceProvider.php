<?php

namespace BinaryCats\LaravelTenant;

use Illuminate\Support\AggregateServiceProvider;

class TenantServiceProvider extends AggregateServiceProvider
{
    /**
     * Location of the provider.
     *
     * @var string
     */
    protected $path = __DIR__;

    /**
     * Name of the package.
     *
     * @var string
     */
    protected $name = 'tenant';

    /**
     * The provider class names.
     *
     * @var array
     */
    protected $providers = [
        Providers\BlueprintMacros::class,
        Providers\EventServiceProvider::class,
        Providers\ReplaceUrlGenerator::class,
        Providers\RequestMacros::class,
        Providers\TenantManagerServiceProvider::class,
    ];

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishConfig()
            ->publishMigrations();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfig();

        parent::register();
    }

    /**
     * Get the events and handlers.
     *
     * @return array
     */
    public function listens()
    {
        return config('tenant.listeners', []);
    }

    /**
     * Merge the config for the repo.
     *
     * @return $this
     */
    protected function mergeConfig()
    {
        $this->mergeConfigFrom("{$this->path}/../config/{$this->name}.php", $this->name);

        return $this;
    }

    /**
     * Publish config for the repo.
     *
     * @return $this
     */
    protected function publishConfig()
    {
        $this->publishes(
            [
                "{$this->path}/../config/{$this->name}.php" => config_path("{$this->name}.php"),
            ], 'config'
        );

        return $this;
    }

    /**
     * Publish Migrations, Seeders and Factories.
     *
     * @return $this
     */
    protected function publishMigrations()
    {
        $this->publishes(
            [
                "{$this->path}/../database" => database_path(),
            ], 'migrations'
        );

        return $this;
    }
}
