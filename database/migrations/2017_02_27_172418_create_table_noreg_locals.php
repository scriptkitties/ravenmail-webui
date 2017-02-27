<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableNoregLocals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('noreg_locals', function (Blueprint $table) {
            $table->uuid('uuid');
            $table->string('local', 64);
            $table->timestamps();

            $table->primary('uuid');
            $table->unique(['local']);

            $table->index('local');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('noreg_locals');
    }
}
