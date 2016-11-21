<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToProductBacklogsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('product_backlogs', function(Blueprint $table)
		{
			$table->foreign('organization_id', 'fk_product_backlogs_organization_id')->references('id')->on('organizations')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('user_id', 'fk_product_backlogs_user_id')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('product_backlogs', function(Blueprint $table)
		{
			$table->dropForeign('fk_product_backlogs_organization_id');
			$table->dropForeign('fk_product_backlogs_user_id');
		});
	}

}
