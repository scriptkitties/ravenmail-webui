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
            $table->uuid('uuid');
            $table->string('local', 64);
            $table->uuid('domain_uuid', 255);
            $table->string('destination', 256);
            $table->boolean('userset')->default(true);
            $table->uuid('verification_uuid');
            $table->timestamps();

            $table->primary('uuid');
            $table->index('destination');

            $table->foreign('domain_uuid')
                ->references('uuid')
                ->on('domains')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('verification_uuid')
                ->references('uuid')
                ->on('verifications')
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
        Schema::drop('aliases');
    }
}
