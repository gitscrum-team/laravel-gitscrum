<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersHasOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('users_has_organizations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('organization_id')->unsigned()->nullable()->index('fk_users_has_organizations_organization_id_idx');
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['user_id', 'organization_id'], 'user_id_and_organization_id_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('users_has_organizations');
    }
}
