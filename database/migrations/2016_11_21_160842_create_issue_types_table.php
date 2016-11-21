<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateIssueTypesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('issue_types', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->unsigned()->nullable();
            $table->string('slug', 60)->nullable();
            $table->string('code', 4)->nullable();
            $table->string('title', 45)->nullable();
            $table->string('description')->nullable();
            $table->char('color', 6)->nullable()->default('FFFFFF');
            $table->integer('position')->unsigned()->nullable()->default(0);
            $table->smallInteger('enabled')->nullable()->default(1);
            $table->index(['parent_id', 'id'], 'id_parent_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('issue_types');
    }
}
