<?php

namespace BinaryCats\LaravelTenant\Eloquent;

use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait MorphToManyTenants
{
    /**
     * Express relation to the tenant.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function tenants(): MorphToMany
    {
        return $this->morphToMany(config('tenant.models.tenant'), 'model', config('tenant.tables.tenantable'));
    }
}
