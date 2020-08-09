<?php

namespace BinaryCats\LaravelTenant\Tests;

use BinaryCats\LaravelTenant\Tenantable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class MockUser extends Authenticatable
{
    use Tenantable;
}
