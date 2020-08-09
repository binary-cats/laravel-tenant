<?php

use Faker\Generator as Faker;
use BinaryCats\LaravelTenant\Contracts\TenantStateful;

$factory->define(App\Models\TenantStatus::class, function (Faker $faker) {
    return [
        'label' => TenantStateful::ACTIVE,
        'allows_use' => true,
    ];
});
