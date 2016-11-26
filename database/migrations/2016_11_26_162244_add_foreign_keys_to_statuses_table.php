<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToStatusesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('statuses', function(Blueprint $table)
		{
			$table->foreign('config_status_id', 'fk_statuses_config_status_id')->references('id')->on('config_statuses')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('user_id', 'fk_statuses_users_id')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('statuses', function(Blueprint $table)
		{
			$table->dropForeign('fk_statuses_config_status_id');
			$table->dropForeign('fk_statuses_users_id');
		});
	}

}
