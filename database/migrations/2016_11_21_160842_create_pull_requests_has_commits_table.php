<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePullRequestsHasCommitsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pull_requests_has_commits', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('pull_request_id')->unsigned()->nullable()->index('fk_pull_requests_has_commits_pull_request_id_idx');
			$table->integer('commit_id')->unsigned()->nullable()->index('fk_pull_requests_has_commits_commit_id_idx');
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
		Schema::drop('pull_requests_has_commits');
	}

}
