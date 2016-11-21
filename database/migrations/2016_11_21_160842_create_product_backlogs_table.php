<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductBacklogsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('product_backlogs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable()->index('fk_product_backlogs_user_id_idx');
            $table->bigInteger('github_id')->unsigned()->nullable()->unique('github_id');
            $table->integer('organization_id')->unsigned()->nullable()->index('fk_product_backlogs_organization_id_idx');
            $table->string('slug', 60)->nullable()->index('repositories_slug');
            $table->string('title')->nullable();
            $table->text('description', 65535)->nullable();
            $table->string('fullname')->nullable();
            $table->boolean('is_private')->nullable();
            $table->string('html_url')->nullable();
            $table->boolean('fork')->nullable();
            $table->string('url')->nullable();
            $table->dateTime('since')->nullable();
            $table->dateTime('pushed_at')->nullable();
            $table->string('git_url')->nullable();
            $table->string('ssh_url')->nullable();
            $table->string('clone_url')->nullable();
            $table->string('homepage')->nullable();
            $table->string('default_branch')->nullable();
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
        Schema::drop('product_backlogs');
    }
}
