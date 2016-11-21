<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateConfigIssueEffortsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('config_issue_efforts', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('title', 25)->nullable();
			$table->decimal('effort', 10)->nullable();
			$table->integer('position')->nullable();
			$table->boolean('enabled')->nullable()->default(1);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('config_issue_efforts');
	}

}
