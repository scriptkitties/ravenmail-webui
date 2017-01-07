<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVerificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('verifications', function (Blueprint $table) {
            $table->uuid('uuid');
            $table->string('code', 12);
            $table->timestamps();

            $table->primary('uuid');
        });

        Schema::table('aliases', function (Blueprint $table) {
            $table->foreign('verification')->references('uuid')->on('verifications');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('verifications');
    }
}
