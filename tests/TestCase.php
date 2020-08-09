<?php

namespace BinaryCats\LaravelTenant\Tests;

use BinaryCats\LaravelTenant\TenantServiceProvider;
use BinaryCats\LaravelTenant\Tests\Migrations\CreateOptionalTenantableModelTable;
use BinaryCats\LaravelTenant\Tests\Migrations\CreateTenantableModelTable;
use CreateTenantableTable;
use CreateTenantsTable;
use CreateTenantStatusesTable;
use Exception;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\Exceptions\Handler;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class TestCase extends OrchestraTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->setUpDatabase();

        $this->withFactories(__DIR__.'/../database/factories');
    }

    /**
     * Set up the environment.
     *
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set(
            'database.connections.sqlite', [
                'driver'   => 'sqlite',
                'database' => ':memory:',
                'prefix'   => '',
            ]
        );
    }

    protected function setUpDatabase()
    {
        include_once __DIR__.'/../database/migrations/2014_01_01_000000_create_tenant_statuses_table.php';
        include_once __DIR__.'/../database/migrations/2014_01_01_000001_create_tenants_table.php';
        include_once __DIR__.'/../database/migrations/2014_01_01_000002_create_tenantable_table.php';

        (new CreateTenantStatusesTable())->up();
        (new CreateTenantsTable())->up();
        (new CreateTenantableTable())->up();
        // fake models to test functionality
        (new CreateTenantableModelTable())->up();
        (new CreateOptionalTenantableModelTable())->up();
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            TenantServiceProvider::class,
        ];
    }

    protected function disableExceptionHandling()
    {
        $this->app->instance(
            ExceptionHandler::class, new class extends Handler {
                public function __construct()
                {
                }

                public function report(Exception $e)
                {
                }

                public function render($request, Exception $exception)
                {
                    throw $exception;
                }
            }
        );
    }
}
