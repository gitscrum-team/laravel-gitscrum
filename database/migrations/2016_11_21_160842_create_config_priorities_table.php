<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateConfigPrioritiesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('config_priorities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug', 60)->nullable();
            $table->string('type', 45)->nullable();
            $table->string('title', 45)->nullable();
            $table->string('description')->nullable();
            $table->char('color', 6)->nullable()->default('f0f0f0');
            $table->integer('position')->unsigned()->nullable();
            $table->boolean('enabled')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('config_priorities');
    }
}
