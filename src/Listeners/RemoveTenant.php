<?php

namespace BinaryCats\LaravelTenant\Listeners;

use BinaryCats\LaravelTenant\TenantManager;
use Illuminate\Auth\Events\Logout;

class RemoveTenant
{
    /**
     * @var BinaryCats\LaravelTenant\TenantManager
     */
    protected $tenantManager;

    /**
     * Create new Middleware.
     *
     * @param BinaryCats\LaravelTenant\TenantManager $tenantManager
     */
    public function __construct(TenantManager $tenantManager)
    {
        $this->tenantManager = $tenantManager;
    }

    /**
     * Handle the event.
     *
     * @param  Illuminate\Auth\Events\Logout $event
     * @return void
     */
    public function handle(Logout $event)
    {
        $this->tenantManager->setTenant(null);
    }
}
