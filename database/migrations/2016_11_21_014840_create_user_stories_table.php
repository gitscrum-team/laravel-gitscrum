<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserStoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_stories', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned()->nullable();
			$table->integer('parent_id')->unsigned()->nullable();
			$table->integer('config_priority_id')->unsigned()->nullable();
			$table->integer('product_backlog_id')->unsigned()->nullable();
			$table->string('slug', 60)->nullable()->default('null')->unique('user_stories_slug');
			$table->text('title', 65535)->nullable();
			$table->text('description', 65535)->nullable();
			$table->text('acceptance_criteria', 65535)->nullable();
			$table->integer('position')->unsigned()->nullable()->default(0);
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
		Schema::drop('user_stories');
	}

}
