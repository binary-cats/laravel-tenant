<?php

namespace BinaryCats\LaravelTenant;

use BinaryCats\LaravelTenant\Eloquent\TenantableScope;
use BinaryCats\LaravelTenant\Eloquent\BelongsToTenant;
use BinaryCats\LaravelTenant\Eloquent\Observers\TenantableObserver;

trait Tenantable
{
    use BelongsToTenant;

    /**
     * @var BinaryCats\Hood\TenantManager
     */
    protected static $manager;

    /**
     * Boot the trait.
     *
     * @return void
     */
    public static function bootTenantable()
    {
        // scope
        $scope = config('tenant.scopes.required') ?: TenantableScope::class;
        // Resolve the manage from container
        static::$manager = app(TenantManager::class);
        // Inject the scope into the models
        static::$manager->setScope($scope)->applyTenantScopes(new static());
        // Add Observer
        static::observe(TenantableObserver::class);
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function rebootTraits()
    {
        static::bootTraits();
    }

    /**
     * Resolve the key for the tenant
     *
     * @return string
     */
    public function getTenantKey()
    {
        return $this->getAttribute($this->getTenantKeyName());
    }

    /**
     * Name of the key to look for
     *
     * @return string
     */
    public function getTenantKeyName()
    {
        return config('tenant.foreign_key');
    }
}
