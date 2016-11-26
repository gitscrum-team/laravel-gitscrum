<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStatusesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('statuses', function (Blueprint $table) {
            $table->increments('id');
			$table->string('statusesable_type', 45)->nullable();
			$table->integer('statusesable_id')->unsigned()->nullable();
			$table->integer('config_status_id')->unsigned()->nullable()->index('fk_statuses_config_status_id_idx');
			$table->integer('user_id')->unsigned()->nullable()->index('fk_statuses_user_id_idx');
			$table->timestamps();
			$table->softDeletes();
			$table->index(['statusesable_type','statusesable_id'], 'statususes_type_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('statuses');
    }
}
