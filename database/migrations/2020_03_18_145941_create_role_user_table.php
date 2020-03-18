<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoleUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('role_user', function (Blueprint $table) {
        $table->increments('id');
        $table->integer('role_id')->unsigned();
        $table->integer('user_id')->unsigned();
      });
    }
    public function down()
    {
      Schema::dropIfExists('role_user');
    }
}
