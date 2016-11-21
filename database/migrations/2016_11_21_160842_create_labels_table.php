<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLabelsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('labels', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable()->index('fk_labels_user_id_idx');
            $table->string('slug', 60)->nullable()->unique('labels_slug');
            $table->string('title', 45)->nullable()->unique('labels_title');
            $table->integer('position')->unsigned()->nullable()->default(0);
            $table->char('color', 6)->nullable()->default('C0C0C0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('labels');
    }
}
