<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateConfigStatusesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('config_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug', 60)->nullable()->default('null')->index('config_statuses_slug');
            $table->string('type', 45)->nullable();
            $table->string('title', 45)->nullable();
            $table->smallInteger('position')->nullable();
            $table->char('color', 6)->nullable()->default('f0f0f0');
            $table->boolean('is_closed')->nullable();
            $table->boolean('default')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('config_statuses');
    }
}
