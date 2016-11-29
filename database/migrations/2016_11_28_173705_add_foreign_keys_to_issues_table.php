<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysToIssuesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('issues', function (Blueprint $table) {
            $table->index('user_id', 'fk_issues_user_id_idx');
            $table->foreign('user_id', 'fk_issues_user_id')
                ->references('id')->on('users')
                ->onUpdate('NO ACTION')->onDelete('NO ACTION');

            $table->index('issue_type_id', 'fk_issues_issue_type_id_idx');
            $table->foreign('issue_type_id', 'fk_issues_issue_type_id')
                ->references('id')->on('issue_types')
                ->onUpdate('NO ACTION')->onDelete('NO ACTION');

            $table->index('product_backlog_id', 'fk_issues_product_backlog_id_idx');
            $table->foreign('product_backlog_id', 'fk_issues_product_backlog_id')
                ->references('id')->on('product_backlogs')
                ->onUpdate('NO ACTION')->onDelete('NO ACTION');

            $table->index('sprint_id', 'fk_issues_sprint_id_idx');
            $table->foreign('sprint_id', 'fk_issues_sprint_id')
                ->references('id')->on('sprints')
                ->onUpdate('NO ACTION')->onDelete('NO ACTION');

            $table->index('user_story_id', 'fk_issues_user_story_id_idx');
            $table->foreign('user_story_id', 'fk_issues_user_story_id')
                ->references('id')->on('user_stories')
                ->onUpdate('NO ACTION')->onDelete('NO ACTION');

            $table->index('config_status_id', 'fk_issues_config_status_id_idx');
            $table->foreign('config_status_id', 'fk_issues_config_status_id')
                ->references('id')->on('config_statuses')
                ->onUpdate('NO ACTION')->onDelete('NO ACTION');

            $table->index('config_issue_effort_id', 'fk_issues_config_issue_effort_id_idx');
            $table->foreign('config_issue_effort_id', 'fk_issues_config_issue_effort_id')
                ->references('id')->on('config_issue_efforts')
                ->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('issues', function (Blueprint $table) {
            $table->dropIndex('fk_issues_user_id_idx');
            $table->dropIndex('fk_issues_issue_type_id_idx');
            $table->dropIndex('fk_issues_product_backlog_id_idx');
            $table->dropIndex('fk_issues_sprint_id_idx');
            $table->dropIndex('fk_issues_user_story_id_idx');
            $table->dropIndex('fk_issues_config_status_id_idx');
            $table->dropIndex('fk_issues_config_issue_effort_id_idx');
            $table->dropForeign('fk_issues_user_id');
            $table->dropForeign('fk_issues_issue_type_id');
            $table->dropForeign('fk_issues_product_backlog_id');
            $table->dropForeign('fk_issues_sprint_id');
            $table->dropForeign('fk_issues_user_story_id');
            $table->dropForeign('fk_issues_config_status_id');
            $table->dropForeign('fk_issues_config_issue_effort_id');
        });
    }
}
