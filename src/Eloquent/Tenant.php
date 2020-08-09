<?php

namespace BinaryCats\LaravelTenant\Eloquent;

use BinaryCats\LaravelTenant\Contracts\TenantStateful;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Tenant extends Model implements TenantStateful
{
    use Concerns\Attributes;
    use Concerns\Scopes;
    use Concerns\Stateful;
    use Concerns\Uuidable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'domain',
        'tenant_status_id',
        'owner_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Record belongs to a Status.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tenantStatus(): BelongsTo
    {
        return $this->belongsTo(config('tenant.models.tenant_status'));
    }

    /**
     * Will resolve the model's accessibles.
     *
     * @param  Illuminate\Database\Eloquent\Model $model
     * @return bool
     */
    public function hasModel(Model $model)
    {
        return $this->morphedByMany($model->getMorphClass(), 'model', config('tenant.tables.tenantable'))->exists(
            [
                $model->getKeyName() => $model->getKey(),
            ]
        );
    }

    /**
     * Get the value for the domain.
     *
     * @return string
     */
    public function domain()
    {
        return $this->domain ?: $this->uuid;
    }

    /**
     * Get the value for the domain.
     *
     * @return bool
     */
    public function isSuperTenant(): bool
    {
        return Str::is($this->getKey(), tenantManager()->getSuperTenantKey());
    }
}
