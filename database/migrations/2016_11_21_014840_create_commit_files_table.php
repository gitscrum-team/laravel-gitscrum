<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCommitFilesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('commit_files', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('commit_id')->unsigned()->nullable();
			$table->string('sha')->nullable();
			$table->string('filename')->nullable();
			$table->string('status')->nullable();
			$table->integer('additions')->unsigned()->nullable();
			$table->integer('deletions')->unsigned()->nullable();
			$table->integer('changes')->unsigned()->nullable();
			$table->string('raw_url')->nullable();
			$table->text('raw')->nullable();
			$table->text('phpcs')->nullable();
			$table->text('patch')->nullable();
			$table->integer('phploc_size')->nullable();
			$table->integer('phploc_lines_of_code')->nullable();
			$table->decimal('phploc_lines_of_code_percent', 10)->nullable();
			$table->integer('phploc_comment_lines_of_code')->nullable();
			$table->decimal('phploc_comment_lines_of_code_percent', 10)->nullable();
			$table->integer('phploc_non-comment_lines_of_code')->nullable();
			$table->decimal('phploc_non-comment_lines_of_code_percent', 10)->nullable();
			$table->integer('phploc_logical_lines_of_code')->nullable();
			$table->decimal('phploc_logical_lines_of_code_percent', 10)->nullable();
			$table->integer('phploc_namespaces')->nullable();
			$table->integer('phploc_interfaces')->nullable();
			$table->integer('phploc_traits')->nullable();
			$table->integer('phploc_classes')->nullable();
			$table->integer('phploc_scope_non-static')->nullable();
			$table->integer('phploc_scope_static')->nullable();
			$table->integer('phploc_visibility_public')->nullable();
			$table->decimal('phploc_visibility_public_percent', 10)->nullable();
			$table->integer('phploc_visibility_non-public')->nullable();
			$table->decimal('phploc_visibility_non-public_percent', 10)->nullable();
			$table->integer('phploc_named_functions')->nullable();
			$table->decimal('phploc_named_functions_percent', 10)->nullable();
			$table->integer('phploc_anonymous_functions')->nullable();
			$table->integer('phploc_constants_global')->nullable();
			$table->decimal('phploc_constants_global_percent', 10)->nullable();
			$table->integer('phploc_constants_class')->nullable();
			$table->decimal('phploc_constants_class_percent', 10)->nullable();
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
		Schema::drop('commit_files');
	}

}
