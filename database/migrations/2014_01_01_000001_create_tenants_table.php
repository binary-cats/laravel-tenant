<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table(), function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->index();
            $table->string('name')->index();
            $table->string('domain')->unique()->index();
            $table->integer('tenant_status_id')->unsigned()->index();
            $table->integer('owner_id')->unsigned()->nullable()->index();
            $table->timestamps();
        });
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
        return config('tenant.tables.tenant');
    }
}
