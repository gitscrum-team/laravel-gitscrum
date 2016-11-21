<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCommitFilePhpcsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('commit_file_phpcs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('commit_file_id')->unsigned()->nullable()->index('fk_commit_file_phpcs_commit_file_id_idx');
            $table->integer('line')->unsigned()->nullable();
            $table->string('message')->nullable();
            $table->string('type', 45)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('commit_file_phpcs');
    }
}
