<?php

use BinaryCats\LaravelTenant\TenantManager;

if (! function_exists('tenant')) {
    /**
     * Get the available tenant instance.
     *
     * @return \BinaryCats\LaravelTenant\Contracts\Tenant | null
     */
    function tenant()
    {
        return app(TenantManager::class)->getTenant();
    }
}

if (! function_exists('tenantManager')) {
    /**
     * Get the available auth instance.
     *
     * @return \BinaryCats\LaravelTenant\TenantManager
     */
    function tenantManager()
    {
        return app(TenantManager::class);
    }
}
