<?php

namespace BinaryCats\LaravelTenant\Eloquent;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToTenant
{
    /**
     * Express relation to the tenant
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tenant() : BelongsTo
    {
        return $this->belongsTo(config('tenant.models.tenant'), config('tenant.foreign_key'));
    }
}
