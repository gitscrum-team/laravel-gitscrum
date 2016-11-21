<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCommitFilePhpcsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('commit_file_phpcs', function(Blueprint $table)
		{
			$table->foreign('commit_file_id', 'fk_commit_file_phpcs_commit_file_id')->references('id')->on('commit_files')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('commit_file_phpcs', function(Blueprint $table)
		{
			$table->dropForeign('fk_commit_file_phpcs_commit_file_id');
		});
	}

}
