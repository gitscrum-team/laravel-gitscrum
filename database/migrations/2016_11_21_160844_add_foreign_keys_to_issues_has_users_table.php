<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToIssuesHasUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('issues_has_users', function (Blueprint $table) {
            $table->foreign('issue_id', 'fk_issues_has_users_issue_id')->references('id')->on('issues')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('user_id', 'fk_issues_has_users_user_id')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('issues_has_users', function (Blueprint $table) {
            $table->dropForeign('fk_issues_has_users_issue_id');
            $table->dropForeign('fk_issues_has_users_user_id');
        });
    }
}
