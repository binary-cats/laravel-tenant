<?php

namespace BinaryCats\LaravelTenant\Tests;

use BinaryCats\LaravelTenant\Eloquent\Tenant;
use Illuminate\Support\Facades\Auth;

class TenantableTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        cache()->clear();
    }

    /**
     * @test
     */
    public function without_authentication_it_will_select_all()
    {
        // create two tenants
        $one = factory(Tenant::class)->create();
        // create a tenantable model for each
        tap(
            $first = TenantableModel::make([])->tenant()->associate($one), function ($model) {
                $model->save();
            }
        )->save();
        // create second
        $two = factory(Tenant::class)->create();
        // second model
        tap(
            $second = TenantableModel::make([])->tenant()->associate($two), function ($model) {
                $model->save();
            }
        )->save();
        // all will return two records
        $this->assertEquals(2, TenantableModel::count());
        // assert properly related model
        $this->assertEquals($one, $first->tenant);
        $this->assertEquals($two, $second->tenant);
    }

    /**
     * @test
     */
    public function with_authentication_it_will_only_select_its_own()
    {
        // create two tenants
        $one = factory(Tenant::class)->create();
        // create a tenantable model for each
        tap(
            $first = TenantableModel::make([])->tenant()->associate($one), function ($model) {
                $model->save();
            }
        )->save();
        // create second
        $two = factory(Tenant::class)->create();
        // second model
        tap(
            $second = TenantableModel::make([])->tenant()->associate($two), function ($model) {
                $model->save();
            }
        )->save();
        // now user
        $user = factory(MockUser::class)->make()->tenant()->associate($one);
        // authenticate a user in a tenant 1
        Auth::login($user);
        // assert search returns only 1 record
        // all will return two records
        $this->assertEquals(1, TenantableModel::count());
        // assert findBy by ID for the second one will return null
        $this->assertNull(TenantableModel::find($two->getKey()));
    }
}
