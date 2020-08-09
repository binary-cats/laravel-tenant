<?php

namespace BinaryCats\LaravelTenant\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Get the events and handlers.
     *
     * @return array
     */
    public function listens()
    {
        return config('tenant.listeners', []);
    }
}
