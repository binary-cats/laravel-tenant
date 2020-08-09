<?php

namespace BinaryCats\LaravelTenant\Contracts;

use Illuminate\Database\Eloquent\Scope;

interface TenantableScope extends Scope
{
    /**
     * Allow for an extra condition
     *
     * @return boolean
     */
    public function bypass();
}
