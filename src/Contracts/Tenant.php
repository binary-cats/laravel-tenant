<?php

namespace BinaryCats\LaravelTenant\Contracts\Tenant;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

interface Tenant
{
    /**
     * Record belongs to a Status
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tenantStatus();

    /**
     * Get the value for the domain
     *
     * @return boolean
     */
    public function isSuperTenant();

    /**
     * Get the value for the domain
     *
     * @return string
     */
    public function domain();
}
