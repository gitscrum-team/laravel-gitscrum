<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('github_id')->unsigned()->nullable()->unique('github_id_UNIQUE');
            $table->string('username')->nullable()->index('login');
            $table->string('url')->nullable();
            $table->string('repos_url')->nullable();
            $table->string('events_url')->nullable();
            $table->string('hooks_url')->nullable();
            $table->string('issues_url')->nullable();
            $table->string('members_url')->nullable();
            $table->string('public_members_url')->nullable();
            $table->string('avatar_url')->nullable();
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->string('blog')->nullable();
            $table->string('location')->nullable();
            $table->string('email')->nullable();
            $table->string('public_repos')->nullable();
            $table->string('html_url')->nullable();
            $table->integer('total_private_repos')->unsigned()->nullable();
            $table->dateTime('since')->nullable();
            $table->integer('disk_usage')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('organizations');
    }
}
