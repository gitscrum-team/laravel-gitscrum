<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserStoriesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('user_stories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable()->index('fk_user_stories_user_id_idx');
            $table->integer('parent_id')->unsigned()->nullable();
            $table->integer('config_priority_id')->unsigned()->nullable()->index('fk_user_stories_config_priority_id_idx');
            $table->integer('product_backlog_id')->unsigned()->nullable()->index('fk_user_stories_product_backlog_id_idx');
            $table->string('slug', 60)->nullable()->default('null')->unique('user_stories_slug');
            $table->text('title', 65535)->nullable();
            $table->text('description', 65535)->nullable();
            $table->text('acceptance_criteria', 65535)->nullable();
            $table->integer('position')->unsigned()->nullable()->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('user_stories');
    }
}
