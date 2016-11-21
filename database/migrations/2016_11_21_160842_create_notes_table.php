<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNotesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable()->index('fk_notes_user_id_idx');
            $table->string('noteable_type', 45)->nullable();
            $table->integer('noteable_id')->unsigned()->nullable();
            $table->string('slug', 60)->nullable()->index('notes_slug');
            $table->text('title', 65535)->nullable();
            $table->integer('position')->unsigned()->nullable()->default(0);
            $table->integer('closed_user_id')->unsigned()->nullable();
            $table->dateTime('closed_at')->nullable();
            $table->timestamps();
            $table->string('deleted_at', 60)->nullable();
            $table->index(['noteable_type', 'noteable_id'], 'notes_type_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('notes');
    }
}
