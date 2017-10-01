<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyProviderIdAndProviderColumnsToUsersOrganizationsProductBacklogsIssuesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE users MODIFY COLUMN provider_id VARCHAR(255) NOT NULL , ADD INDEX `provider_id` (`provider_id`)');
        DB::statement("ALTER TABLE users MODIFY COLUMN provider ENUM('gitlab', 'github', 'bitbucket') NOT NULL");

        DB::statement('ALTER TABLE organizations MODIFY COLUMN provider_id VARCHAR(255) NOT NULL , ADD INDEX `provider_id` (`provider_id`)');
        DB::statement("ALTER TABLE organizations MODIFY COLUMN provider ENUM('gitlab', 'github', 'bitbucket') NOT NULL");

        DB::statement('ALTER TABLE product_backlogs MODIFY COLUMN provider_id VARCHAR(255) NOT NULL , ADD INDEX `provider_id` (`provider_id`)');

        DB::statement('ALTER TABLE issues MODIFY COLUMN provider_id VARCHAR(255) , ADD INDEX `provider_id` (`provider_id`)');
        DB::statement("ALTER TABLE issues MODIFY COLUMN provider ENUM('gitlab', 'github', 'bitbucket') NOT NULL");

    }

}
