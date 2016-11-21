<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToPullRequestsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('pull_requests', function (Blueprint $table) {
            $table->foreign('base_branch_id', 'fk_pull_requests_base_branch_id')->references('id')->on('branches')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('head_branch_id', 'fk_pull_requests_head_branch_id')->references('id')->on('branches')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('pull_requests', function (Blueprint $table) {
            $table->dropForeign('fk_pull_requests_base_branch_id');
            $table->dropForeign('fk_pull_requests_head_branch_id');
        });
    }
}
