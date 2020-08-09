<?php

namespace BinaryCats\LaravelTenant\Tests\Migrations;

use BinaryCats\LaravelTenant\Seeders\TenantStatusSeeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOptionalTenantableModelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'optional_tenantable_models', function (Blueprint $table) {
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
        Schema::dropIfExists('optional_tenantable_models');
    }
}
