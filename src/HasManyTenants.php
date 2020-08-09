<?php

namespace BinaryCats\LaravelTenant;

use BinaryCats\LaravelTenant\Eloquent\MorphToManyTenants;

trait HasManyTenants
{
    use MorphToManyTenants;
}
