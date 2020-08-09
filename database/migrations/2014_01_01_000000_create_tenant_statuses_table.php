<?php

use BinaryCats\LaravelTenant\Seeders\TenantStatusSeeder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenantStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table(), function (Blueprint $table) {
            $table->increments('id');
            $table->string('label');
            $table->string('description');
            $table->boolean('allows_use')->default(true);
        });

        Artisan::call('db:seed', [
            '--class' => TenantStatusSeeder::class,
            '--force' => true,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->table());
    }

    /**
     * Resolve Table name from config.
     *
     * @return
     */
    protected function table()
    {
        return config('tenant.tables.tenant_status');
    }
}
