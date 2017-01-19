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
            $table->string('local', 64);
            $table->uuid('domain_uuid');
            $table->timestamps();

            $table->primary('uuid');
            $table->unique(['local', 'domain_uuid']);

            $table->index('local');
            $table->index('domain_uuid');

            $table->foreign('domain_uuid')
                ->references('uuid')
                ->on('domains')
                ->onDelete('cascade')
                ->onUpdate('cascade');
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
