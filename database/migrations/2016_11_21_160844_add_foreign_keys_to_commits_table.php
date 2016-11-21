<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCommitsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('commits', function (Blueprint $table) {
            $table->foreign('branch_id', 'fk_commits_branch_id')->references('id')->on('branches')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('issue_id', 'fk_commits_issue_id')->references('id')->on('issues')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('product_backlog_id', 'fk_commits_product_backlog_id')->references('id')->on('product_backlogs')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('user_id', 'fk_commits_user_id')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('commits', function (Blueprint $table) {
            $table->dropForeign('fk_commits_branch_id');
            $table->dropForeign('fk_commits_issue_id');
            $table->dropForeign('fk_commits_product_backlog_id');
            $table->dropForeign('fk_commits_user_id');
        });
    }
}
