<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToUserStoriesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('user_stories', function (Blueprint $table) {
            $table->foreign('config_priority_id', 'fk_user_stories_config_priority_id')->references('id')->on('config_priorities')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('product_backlog_id', 'fk_user_stories_product_backlog_id')->references('id')->on('product_backlogs')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('user_id', 'fk_user_stories_user_id')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('user_stories', function (Blueprint $table) {
            $table->dropForeign('fk_user_stories_config_priority_id');
            $table->dropForeign('fk_user_stories_product_backlog_id');
            $table->dropForeign('fk_user_stories_user_id');
        });
    }
}
