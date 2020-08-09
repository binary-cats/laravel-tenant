<?php

namespace BinaryCats\LaravelTenant;

use BinaryCats\LaravelTenant\Eloquent\TenantableScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Traits\Macroable;

class TenantManager
{
    use Macroable;

    /**
     * Tenant record
     *
     * @var Illuminate\Database\Eloquent\Model
     */
    protected $tenant;

    /**
     * List of models where loading is deferred
     *
     * @var Illuminate\Support\Collection
     */
    protected $deferredModels;

    /**
     * Define what scope to User
     *
     * @var string
     */
    protected $scope = TenantableScope::class;

    /**
     * Create new TenantManager
     */
    public function __construct()
    {
        $this->deferredModels = collect([]);
    }

    /**
     * Set a tenant to scope by.
     *
     * @param  mixed $tenant
     * @return $this
     */
    public function setTenant($tenant)
    {
        $this->tenant = $tenant;

        return $this;
    }

    /**
     * Return the tenant
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getTenant()
    {
        return $this->tenant;
    }

    /**
     * Set Scope value
     *
     * @param string $scope
     */
    public function setScope($scope)
    {
        $this->scope = $scope;

        return $this;
    }

    /**
     * Get Scope value
     *
     * @param Illuminate\Database\Eloquent\Scope;
     */
    public function getScope() : Scope
    {
        // Fetch the scope
        $scope = $this->scope ?: config('tenant.scopes.required');
        // return
        return new $scope;
    }

    /**
     * UUID of the Tenant
     *
     * @return UUID string | null
     */
    public function uuid()
    {
        return data_get($this->tenant, 'uuid');
    }

    /**
     * Applies applicable tenant scopes to a model.
     *
     * @param Model|BelongsToTenants $model
     */
    public function applyTenantScopes(Model $model)
    {
        if ($this->getTenant()) {
            return $model->addGlobalScope($this->getScope());
        }
        // Else, defer to a later stage
        $this->deferredModels->put(get_class($model), [$model,$this->getScope()]);
    }

    /**
     * Apply the scope to the models that were booted before setting the Tenant
     *
     * @return void
     */
    public function applyTenantScopesToDeferredModels()
    {
        $this->deferredModels->each(
            function ($item) {
                // Split the mode and scope
                list($model, $scope) = $item;
                // apply model scope
                $model->addGlobalScope($scope);
            }
        );
    }

    /**
     * Resolve Model
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public function model()
    {
        // Model
        $model = config('tenant.models.tenant');
        // Resolve
        return app()->make($model);
    }

    /**
     * Find a tenant based on the
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public function findTenant($arguments)
    {
        return $this->model()->where($arguments)->first();
    }

    /**
     * Fetch the ID of the super Tenant
     *
     * @return int
     */
    public function getSuperTenantKey()
    {
        return config('tenant.super_tenant_key');
    }
}
