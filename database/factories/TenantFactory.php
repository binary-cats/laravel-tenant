<?php

use BinaryCats\LaravelTenant\Contracts\TenantStateful;
use BinaryCats\LaravelTenant\Eloquent\Tenant;
use Faker\Generator as Faker;

$factory->define(Tenant::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'domain' => $faker->word,
        'tenant_status_id' => TenantStateful::ACTIVE,
    ];
});

$factory->state(Tenant::class, 'unconfirmed', [
    'tenant_status_id' => TenantStateful::UNCONFIRMED,
])->state(Tenant::class, 'active', [
    'tenant_status_id' => TenantStateful::ACTIVE,
])->state(Tenant::class, 'suspended', [
    'tenant_status_id' => TenantStateful::SUSPENDED,
])->state(Tenant::class, 'abandoned', [
    'tenant_status_id' => TenantStateful::ABANDONED,
])->state(Tenant::class, 'inactivated', [
    'tenant_status_id' => TenantStateful::INACTIVED,
]);
