<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Binary Cats | Tenant Models
    |--------------------------------------------------------------------------
    |
    | This option controls what model implementations
    */

    'models' => [

        // Eloquent Model responsible for the Tenant Record
        'tenant' => \BinaryCats\LaravelTenant\Eloquent\Tenant::class,

        // Eloquent Model responsible for the Tenant Status Record
        'tenant_status' => \BinaryCats\LaravelTenant\Eloquent\TenantStatus::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Binary Cats | Tenant Scopes
    |--------------------------------------------------------------------------
    |
    | This option controls model scopes:
    */

    'scopes' => [
        // If you do not need additional scoping controls, you can keep this value empty
        // and BinaryCats\LaravelTenant\Eloquent\TenantableScope will be used
        'required' => null,

        // If you do not need additional scoping controls, you can keep this value empty
        // and BinaryCats\LaravelTenant\Eloquent\OptionalTenantableScope will be used
        'optional' => null,
    ],

    /*
    |--------------------------------------------------------------------------
    | Binary Cats | Tenant Foreign Key
    |--------------------------------------------------------------------------
    |
    | This option controls the field name of the primary key
    */
   'foreign_key' => 'tenant_id',

   /*
    |--------------------------------------------------------------------------
    | Binary Cats | Super Tenant ID
    |--------------------------------------------------------------------------
    |
    | This option controls the true ID of the super tenant
    */
   'super_tenant_key' => env('BC_SUPER_TENANT_KEY', 0),

   /*
    |--------------------------------------------------------------------------
    | Binary Cats | Initial State of a Tenant
    |--------------------------------------------------------------------------
    |
    | When the model is created, what status it should be given by default
    */
   'initial_status_id' => \BinaryCats\LaravelTenant\Contracts\TenantStateful::UNCONFIRMED,

   /*
    |--------------------------------------------------------------------------
    | Binary Cats | Routing rules
    |--------------------------------------------------------------------------
    |
    | Whenever a route is requested, one of the items needed is a subdomain.
    |
    */
   'routing' => [

       // Set `autobind` to true to ensure it is resolved automatically
       'autobind' => true,

       // Set `subdomainKey` to the name of the parameter to bind
       'subdomainKey' => 'account',

       // If you need to replace the URL generator with yet another
       // Must be implemeting Illuminate\Contracts\Routing\UrlGenerator
       'generator' => \BinaryCats\LaravelTenant\Routing\UrlGenerator::class,
   ],

   /*
    |--------------------------------------------------------------------------
    | Binary Cats | Tenants table
    |--------------------------------------------------------------------------
    |
    | Name of the table to hold the tenants
    */
    'tables' => [

        // Name of the table for the Tenant model
        'tenant' => 'tenants',

        // Name of the table for the Tenant Status model
        'tenant_status' => 'tenant_statuses',

        // Name of the table to store plural tenant relations for owning multiple tenants
        'tenantable' => 'tenantables',
    ],

    /*
    |--------------------------------------------------------------------------
    | Binary Cats | Tenants table
    |--------------------------------------------------------------------------
    |
    | Name of the table to hold the tenants
    */
    'listeners' => [
        \Illuminate\Auth\Events\Authenticated::class => [
            \BinaryCats\LaravelTenant\Listeners\SetTenant::class,
        ],
        \Illuminate\Auth\Events\Logout::class => [
            \BinaryCats\LaravelTenant\Listeners\RemoveTenant::class,
        ],
    ],
];
