<?php

namespace BinaryCats\LaravelTenant\Eloquent\Observers;

use Illuminate\Database\Eloquent\Model;

class TenantStatusObserver
{
    /**
     * Handle the tenant "creating" event.
     *
     * @param  \Illuminate\Database\Eloquent\ModelIlluminate\Database\Eloquent\Model $tenant
     * @return void
     */
    public function creating(Model $tenant)
    {
        $this->setTenantStatus($tenant);
    }

    /**
     * Set initial status value.
     *
     * @param \Illuminate\Database\Eloquent\Model $tenant
     */
    protected function setTenantStatus(Model $tenant)
    {
        $tenant->setAttribute($tenant->getStatusName(), $this->getTenantStatus($tenant));

        return $this;
    }

    /**
     * Get the tenant status.
     *
     * @param  \Illuminate\Database\Eloquent\Model $tenant
     * @return int
     */
    protected function getTenantStatus(Model $tenant)
    {
        return $tenant->getStatus() ?: config('tenant.initial_status_id');
    }
}
