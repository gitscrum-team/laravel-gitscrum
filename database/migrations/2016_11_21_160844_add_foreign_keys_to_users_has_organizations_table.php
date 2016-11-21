<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToUsersHasOrganizationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users_has_organizations', function(Blueprint $table)
		{
			$table->foreign('organization_id', 'fk_users_has_organizations_organization_id')->references('id')->on('organizations')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('user_id', 'fk_users_has_organizations_user_id')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users_has_organizations', function(Blueprint $table)
		{
			$table->dropForeign('fk_users_has_organizations_organization_id');
			$table->dropForeign('fk_users_has_organizations_user_id');
		});
	}

}
