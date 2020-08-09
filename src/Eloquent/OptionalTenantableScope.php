<?php

namespace BinaryCats\LaravelTenant\Eloquent;

use BinaryCats\LaravelTenant\TenantManager;
use Illuminate\Database\Eloquent\Model;
use BinaryCats\LaravelTenant\Contracts\TenantableScope as Scope;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class OptionalTenantableScope implements Scope
{
    /**
     * All of the extensions to be added to the builder.
     *
     * @var array
     */
    protected $extensions = ['withoutTenant'];

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $builder
     * @param  \Illuminate\Database\Eloquent\Model   $model
     * @return void
     */
    public function apply(EloquentBuilder $builder, Model $model)
    {
        return $this->bypass() ? $builder : $this->handle($builder, $model);
    }

    /**
     * Allow for an extra conditions
     *
     * @return boolean
     */
    public function bypass()
    {
        return false;
    }

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $builder
     * @param  \Illuminate\Database\Eloquent\Model   $model
     * @return void
     */
    protected function handle(EloquentBuilder $builder, Model $model)
    {
        return $builder->where(
            function ($advanced) use ($model) {
                // modelField is null
                $tenantForeignKey = $model->qualifyColumn(config('tenant.foreign_key'));
                // build query
                return $advanced->whereNull($tenantForeignKey)->orWhereHas(
                    'tenant', function ($tenant) {
                        $tenant->whereKey($this->tenant()->getKey());
                    }
                );
            }
        );
    }

    /**
     * Resolve the ID of the tenant
     *
     * @return BinaryCats\Hood\Tenant
     */
    protected function tenant()
    {
        return app(TenantManager::class)->getTenant();
    }

    /**
     * Extend the query builder with the needed functions.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    public function extend(EloquentBuilder $builder)
    {
        foreach ($this->extensions as $extension) {
            $this->{"add{$extension}"}($builder);
        }
    }

    /**
     * Add the without-tenant extension to the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addWithoutTenant(EloquentBuilder $builder)
    {
        $builder->macro(
            'withoutTenant', function (EloquentBuilder $builder) {
                return $builder->withoutGlobalScope($this);
            }
        );
    }
}
