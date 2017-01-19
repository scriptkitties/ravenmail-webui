<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDomainModeratorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('domain_moderators', function (Blueprint $table) {
            $table->uuid('uuid');
            $table->uuid('domain_uuid');
            $table->uuid('user_uuid');
            $table->boolean('admin')->default(false);
            $table->timestamps();

            $table->primary('uuid');
            $table->unique(['domain_uuid', 'user_uuid']);

            $table->index('domain_uuid');
            $table->index('user_uuid');

            $table->foreign('domain_uuid')
                ->references('uuid')
                ->on('domains')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('user_uuid')
                ->references('uuid')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('domain_moderators');
    }
}
