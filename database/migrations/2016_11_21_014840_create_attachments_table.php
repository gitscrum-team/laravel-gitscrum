<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAttachmentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('attachments', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('attachmentable_type', 45)->nullable();
			$table->integer('attachmentable_id')->unsigned()->nullable();
			$table->integer('user_id')->unsigned()->nullable()->index('attachments_user_id');
			$table->string('filename_original')->nullable();
			$table->string('filename_new')->nullable();
			$table->string('mimetype', 60)->nullable();
			$table->decimal('size', 10)->nullable();
			$table->timestamps();
			$table->string('deleted_at', 45)->nullable();
			$table->index(['attachmentable_type','attachmentable_id'], 'attachments_type_id');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('attachments');
	}

}
