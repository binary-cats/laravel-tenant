<?php

namespace BinaryCats\LaravelTenant\Eloquent;

use BinaryCats\LaravelTenant\Contracts\TenantStateful;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TenantStatus extends Model implements TenantStateful
{
    use Concerns\Status\Attributes;
    use Concerns\Status\Scopes;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'label',
        'allows_use',
    ];

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
     * Return the field to which the comparison needs to be made
     *
     * @return string
     */
    public function getStatusName()
    {
        return $this->keyName();
    }

    /**
     * Status may have many Tenant Records
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tenants() : HasMany
    {
        return $this->hasMany(config('tenant.models.tenant'));
    }
}
