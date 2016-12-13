<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('github_id')->nullable()->unique();
            $table->string('username')->nullable()->index('users_username');
            $table->string('name');
            $table->string('avatar')->nullable();
            $table->string('html_url')->nullable();
            $table->string('email')->nullable();
            $table->string('password')->nullable()->default('null');
            $table->string('remember_token', 100)->nullable();
            $table->string('bio')->nullable();
            $table->string('location')->nullable();
            $table->string('blog')->nullable();
            $table->date('since')->nullable();
            $table->string('token')->nullable();
            $table->integer('main_repository')->unsigned()->nullable();
            $table->string('position_held', 45)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('users');
    }
}
