<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('local', 64);
            $table->string('domain', 255);
            $table->string('password', 60);
            $table->boolean('admin')->default(false);
            $table->boolean('active')->default(true);
            $table->rememberToken();
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
        Schema::drop('users');
    }
}
