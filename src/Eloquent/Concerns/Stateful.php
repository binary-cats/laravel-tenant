<?php

namespace BinaryCats\LaravelTenant\Eloquent\Concerns;

use BinaryCats\LaravelTenant\Eloquent\Observers\TenantStatusObserver;

trait Stateful
{
    use Status\Attributes;
    use Status\Scopes;

    /**
     * Boot the trait.
     *
     * @return void
     */
    public static function bootStateful()
    {
        static::observe(
            [
            TenantStatusObserver::class,
            ]
        );
    }

    /**
     * Return the value of the field to which the comparison needs to be made
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->getAttribute($this->getStatusName());
    }

    /**
     * Resolve the Status field Name
     *
     * @return string
     */
    public function getStatusName()
    {
        return 'tenant_status_id';
    }

    /**
     * Decorate the Status label
     *
     * @return string
     */
    public function getStatusLabelAttribute()
    {
        return data_get($this->tenantStatus, 'label');
    }
}
