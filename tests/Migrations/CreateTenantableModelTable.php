<?php

namespace BinaryCats\LaravelTenant\Tests\Migrations;

use BinaryCats\LaravelTenant\Seeders\TenantStatusSeeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTenantableModelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'tenantable_models', function (Blueprint $table) {
                $table->id();
                $table->tenant();
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tenantable_models');
    }
}
