<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCommitFilesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('commit_files', function (Blueprint $table) {
            $table->foreign('commit_id', 'fk_commit_files_commit_id')->references('id')->on('commits')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('commit_files', function (Blueprint $table) {
            $table->dropForeign('fk_commit_files_commit_id');
        });
    }
}
