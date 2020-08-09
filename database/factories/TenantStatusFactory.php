<?php

use BinaryCats\LaravelTenant\Contracts\TenantStateful;
use Faker\Generator as Faker;

$factory->define(App\Models\TenantStatus::class, function (Faker $faker) {
    return [
        'label' => TenantStateful::ACTIVE,
        'allows_use' => true,
    ];
});
