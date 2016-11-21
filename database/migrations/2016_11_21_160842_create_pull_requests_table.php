<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePullRequestsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pull_requests', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('github_id')->unsigned()->nullable()->unique('github_id_UNIQUE');
			$table->integer('head_branch_id')->unsigned()->nullable()->index('fk_pull_requests_head_branch_id_idx');
			$table->integer('base_branch_id')->unsigned()->nullable()->index('fk_pull_requests_base_branch_id_idx');
			$table->integer('user_id')->nullable();
			$table->integer('product_backlog_id')->unsigned()->nullable();
			$table->integer('number')->unsigned()->nullable();
			$table->string('url')->nullable();
			$table->string('html_url')->nullable();
			$table->string('issue_url')->nullable();
			$table->string('commits_url')->nullable();
			$table->string('state')->nullable();
			$table->string('title')->nullable();
			$table->text('body')->nullable();
			$table->dateTime('github_created_at')->nullable();
			$table->dateTime('github_updated_at')->nullable();
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
		Schema::drop('pull_requests');
	}

}
