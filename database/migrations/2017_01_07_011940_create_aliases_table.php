<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAliasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aliases', function (Blueprint $table) {
            $table->increments('id');
            $table->string('local', 64);
            $table->string('domain', 255);
            $table->string('destination', 256);
            $table->boolean('userset')->default(true);
            $table->boolean('active')->default(false);
            $table->uuid('verification')->nullable();
            $table->timestamps();

            $table->index('destination');

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
        Schema::drop('aliases');
    }
}
