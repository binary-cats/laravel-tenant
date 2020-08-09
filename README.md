# A Simple Laravel Tenancy

![https://github.com/binary-cats/laravel-tenant/actions](https://github.com/binary-cats/laravel-tenant/workflows/PHP%20Composer/badge.svg)
![https://github.styleci.io/repos/266611306](https://github.styleci.io/repos/266611306/shield)
![https://scrutinizer-ci.com/g/binary-cats/laravel-mailgun-webhooks/](https://scrutinizer-ci.com/g/binary-cats/laravel-tenant/badges/quality-score.png?b=master)

This Laravel package allows you to drop-in multi-tenancy. It is a little opinionated and you are free to update and tinker with it.

<img src="resources/img/laravel-tenant.png" alt="Laravel Tenant" width="200"/>

What it does: Allows you to create a subdomain driven multi-tenant application where each tenant has a single, dedicated subdomain. Your models can be strictly tenantable, or shared between tenants. You are free to turn off subdomain routing.

## Installation and Setup

This package requires PHP 7 and Laravel 5.6 or higher. Latest version requires PHP 7.2 and Laravel 7 and above.

```bash
php composer require binary-cats\laravel-tenant
```

THe package will register itself.

### Resources

Publish all resources:

```bash
php artisan vendor:publish --provider=BinaryCats\\LaravelTenant\\TenantServiceProvider
```
or, separately:
```bash
php artisan vendor:publish --provider=BinaryCats\\LaravelTenant\\TenantServiceProvider --tag=migrations
php artisan vendor:publish --provider=BinaryCats\\LaravelTenant\\TenantServiceProvider --tag=config
```

### Configuration

## Usage

* [Models](#model-setup)
* [Events](#event-setup)

To fully use Laravel Tenant you need to prepare your models and routing. Laravel Tenant will work best within authenticated environment; If you plan to use if for non-authenticated environment, I suggest creating a Service Provider resolving the tenant via `TenantManager` to prevent any data seeping.

### Model Setup

Any model you expect to be scoped globally nees to:

1. Have a foreign tenant key:
2. Import Tenantable trait:

```php
<?php

namespace App\Models;

use BinaryCats\LaravelTenant\Tenantable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Tenantable;
```

This will add a (Global scope)[https://laravel.com/docs/7.x/eloquent#global-scopes] and an automatic model observer, populating models with current tenant value.

Alternativesly, you can use an `OptionalTenantable` trait; it will scope for the exact match of the tenant key OR null value of the model tenant key. Use case scenario is when you have a shared set of models in addition to which the tenant may add their own. Think Gmail folders: Inbox and Trash are labels present in each user's mailbox; however, you are free to add more tags and they are visible only to you.

**_Caution_**

Do not include tenant_id into fillable attributes; it should be protected and, preferrably, hidden to make sure you do not accidentally expose tenant information.

### Event Setup

Laravel Tenant provides automatic listeners you may hook up to streamline your app:
```php
    /*
    |--------------------------------------------------------------------------
    | Binary Cats | Tenants table
    |--------------------------------------------------------------------------
    |
    | Name of the table to hold the tenants
    */
    'listeners' => [
        \Illuminate\Auth\Events\Authenticated::class => [
            # Will register a tenant within TenantManager based on the tenant of the authenticated user
            \BinaryCats\LaravelTenant\Listeners\SetTenant::class,
        ],
        \Illuminate\Auth\Events\Logout::class => [
            # Will de-register a tenant within TenantManager based on the tenant of the user being loged out
            \BinaryCats\LaravelTenant\Listeners\RemoveTenant::class,
        ],
    ],
```

### Subdomains
Laravel Tenant provides resolution logic for subdomains out of the box. If this functionailty is not needed, toggle config `tenant.routing.autobind` switch to `false`:

```php
    /*
    |--------------------------------------------------------------------------
    | Binary Cats | Routing rules
    |--------------------------------------------------------------------------
    |
    | Whenever a route is requested, one of the items needed is a subdomain.
    |
    */
   'routing' => [

        # Set `autobind` to true to ensure it is resolved automatically
        'autobind' => true,

        # Set `subdomainKey` to the name of the parameter to bind
        'subdomainKey' => 'tenant',

        # If you need to replace the URL generator with yet another
        # Must be implemeting Illuminate\Contracts\Routing\UrlGenerator
        'generator' => \BinaryCats\LaravelTenant\Routing\UrlGenerator::class,
   ],
```

## Testing

Run the tests with:

```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security-related issues, please email info@binarycats.io instead of using the issue tracker.

## Credits

- [Cyrill Kalita](https://bitbucket.org/cyrillkalita)
- [All Contributors](../../contributors)

## Support us
Binary Cats is a web service agency based in Roselle, Illinois.

Does your business depend on our contributions? Reach out!
All pledges will be dedicated to allocating workforce on maintenance and new awesome stuff.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
