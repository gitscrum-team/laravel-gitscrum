<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateIssuesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('issues', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->unsigned()->nullable();
            $table->bigInteger('github_id')->unsigned()->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('issue_type_id')->unsigned()->nullable();
            $table->integer('issue_effort_id')->unsigned()->nullable();
            $table->integer('product_backlog_id')->unsigned()->nullable();
            $table->integer('sprint_id')->unsigned()->nullable();
            $table->integer('user_story_id')->unsigned()->nullable();
            $table->integer('branch_id')->unsigned()->nullable();
            $table->integer('config_status_id')->unsigned()->nullable();
            $table->integer('number')->unsigned()->nullable();
            $table->integer('effort')->nullable();
            $table->string('slug')->nullable()->unique('issues_slug');
            $table->string('title')->nullable();
            $table->text('description', 65535)->nullable();
            $table->date('due_date')->nullable();
            $table->string('state')->nullable();
            $table->integer('position')->unsigned()->nullable()->default(0);
            $table->boolean('is_planning_poker')->nullable()->default(0);
            $table->integer('closed_user_id')->unsigned()->nullable();
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
        Schema::drop('issues');
    }
}
