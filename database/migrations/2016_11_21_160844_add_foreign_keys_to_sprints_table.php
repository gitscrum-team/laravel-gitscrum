<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToSprintsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('sprints', function(Blueprint $table)
		{
			$table->foreign('config_status_id', 'fk_sprints_config_status_id')->references('id')->on('config_statuses')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('product_backlog_id', 'fk_sprints_product_backlog_id')->references('id')->on('product_backlogs')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('user_id', 'fk_sprints_user_id')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('sprints', function(Blueprint $table)
		{
			$table->dropForeign('fk_sprints_config_status_id');
			$table->dropForeign('fk_sprints_product_backlog_id');
			$table->dropForeign('fk_sprints_user_id');
		});
	}

}
