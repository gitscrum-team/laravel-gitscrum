<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToPullRequestsHasCommitsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('pull_requests_has_commits', function (Blueprint $table) {
            $table->foreign('commit_id', 'fk_pull_requests_has_commits_commit_id')->references('id')->on('commits')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('pull_request_id', 'fk_pull_requests_has_commits_pull_request_id')->references('id')->on('pull_requests')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('pull_requests_has_commits', function (Blueprint $table) {
            $table->dropForeign('fk_pull_requests_has_commits_commit_id');
            $table->dropForeign('fk_pull_requests_has_commits_pull_request_id');
        });
    }
}
