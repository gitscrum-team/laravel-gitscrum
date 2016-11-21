<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSprintsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('sprints', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable()->index('fk_sprints_user_id_idx');
            $table->integer('product_backlog_id')->unsigned()->nullable()->index('fk_sprints_product_backlog_id_idx');
            $table->integer('config_status_id')->unsigned()->nullable()->index('fk_sprints_config_status_id_idx');
            $table->string('slug', 60)->nullable()->index('sprints_slug');
            $table->string('title')->nullable();
            $table->text('description', 65535)->nullable();
            $table->string('version', 10)->nullable();
            $table->date('date_start')->nullable();
            $table->date('date_finish')->nullable();
            $table->smallInteger('state')->unsigned()->nullable();
            $table->integer('position')->unsigned()->nullable()->default(0);
            $table->char('color', 6)->nullable()->default('257e4a');
            $table->boolean('is_private')->nullable()->default(0);
            $table->dateTime('closed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('sprints');
    }
}
