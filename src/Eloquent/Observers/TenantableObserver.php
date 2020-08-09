<?php

namespace BinaryCats\LaravelTenant\Eloquent\Observers;

use BinaryCats\LaravelTenant\TenantManager;
use Illuminate\Database\Eloquent\Model;

class TenantableObserver extends Observer
{
    /**
     * Handle the "creating" mmodel.
     *
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    public function creating(Model $model)
    {
        if (empty($model->getTenantKey())) {
            $model->tenant()->associate($this->tenant());
        }
    }

    /**
     * Try to obtain the tenant instance and set the value
     *
     * @return int | null
     */
    protected function tenant()
    {
        return $this->manager()->getTenant();
    }

    /**
     * Resolve manager
     *
     * @return BinaryCats\Hood\TenantManager
     */
    protected function manager()
    {
        return app(TenantManager::class);
    }
}
