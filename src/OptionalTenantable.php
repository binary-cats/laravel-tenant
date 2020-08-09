<?php

namespace BinaryCats\LaravelTenant;

use BinaryCats\LaravelTenant\Eloquent\OptionalTenantableScope;
use BinaryCats\LaravelTenant\Eloquent\Observers\TenantableObserver;

trait OptionalTenantable
{
    use Tenantable;

    /**
     * Boot the trait.
     *
     * @return void
     */
    public static function bootTenantable()
    {
        // scope
        // Fetch the scope
        $scope = config('tenant.scopes.optional') ?: OptionalTenantableScope::class;
        // Resolve the manage from container
        static::$manager = app(TenantManager::class);
        // Inject the scope into the models
        static::$manager->setScope($scope)->applyTenantScopes(new static());
        // Add Observer
        static::observe(TenantableObserver::class);
    }
}
