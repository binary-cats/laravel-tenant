<?php

namespace BinaryCats\LaravelTenant\Tests;

use BinaryCats\LaravelTenant\Tenantable;
use Illuminate\Database\Eloquent\Model;

class TenantableModel extends Model
{
    use Tenantable;
}
