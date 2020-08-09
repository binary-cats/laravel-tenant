<?php

namespace BinaryCats\LaravelTenant\Listeners;

use BinaryCats\LaravelTenant\TenantManager;
use Illuminate\Auth\Events\Authenticated;

class SetTenant
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
     * @param  Illuminate\Auth\Events\Authenticated $event
     * @return void
     */
    public function handle(Authenticated $event)
    {
        $this->setTenant($event->user)->applyDeferredScopes();
    }

    /**
     * Resolve Tenant from Mamanger.
     *
     * @return $this
     */
    protected function getTenant($user)
    {
        return $this->tenantManager->getTenant();
    }

    /**
     * Set the tenant from the user;
     * But we also need to boot the user again.
     *
     * @param  User $user
     * @return $this
     */
    protected function setTenant($user)
    {
        // reset Tenant
        $this->tenantManager->setTenant($user->tenant);
        // return
        return $this;
    }

    /**
     * Reboot the models that are using Tenantable, but have not received the global scope yet.
     *
     * @param  User $user
     * @return $this
     */
    protected function applyDeferredScopes()
    {
        $this->tenantManager->applyTenantScopesToDeferredModels();

        return $this;
    }
}
