<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyProviderColumnsToAddGiteaProvider extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN provider ENUM('gitlab', 'github', 'bitbucket', 'gitea') NOT NULL");

        DB::statement("ALTER TABLE organizations MODIFY COLUMN provider ENUM('gitlab', 'github', 'bitbucket', 'gitea') NOT NULL");

        DB::statement("ALTER TABLE issues MODIFY COLUMN provider ENUM('gitlab', 'github', 'bitbucket', 'gitea') NOT NULL");
    }
}
