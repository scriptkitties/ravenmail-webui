<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNoregAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('noreg_addresses', function (Blueprint $table) {
            $table->uuid('uuid');
            $table->string('local', 64)->default('');
            $table->string('domain', 255)->nullable();
            $table->timestamps();

            $table->unique(['local', 'domain']);

            $table->foreign('domain')->references('name')->on('domains');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('noreg_addresses');
    }
}
