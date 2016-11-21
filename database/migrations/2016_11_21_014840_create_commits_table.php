<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCommitsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('commits', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('product_backlog_id')->unsigned()->nullable();
			$table->integer('branch_id')->unsigned()->nullable();
			$table->integer('user_id')->unsigned()->nullable();
			$table->integer('issue_id')->unsigned()->nullable();
			$table->string('sha')->nullable();
			$table->string('url')->nullable();
			$table->text('message', 65535)->nullable();
			$table->string('html_url')->nullable();
			$table->dateTime('date')->nullable();
			$table->string('tree_sha')->nullable();
			$table->string('tree_url')->nullable();
			$table->timestamps();
			$table->softDeletes();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('commits');
	}

}
