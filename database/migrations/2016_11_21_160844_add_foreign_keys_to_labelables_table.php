<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToLabelablesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('labelables', function(Blueprint $table)
		{
			$table->foreign('label_id', 'fk_labelables_label_id')->references('id')->on('labels')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('user_id', 'fk_labelables_user_id')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('labelables', function(Blueprint $table)
		{
			$table->dropForeign('fk_labelables_label_id');
			$table->dropForeign('fk_labelables_user_id');
		});
	}

}
