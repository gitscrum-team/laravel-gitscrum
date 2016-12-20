<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GithubIdToProviderId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('github_id', 'provider_id');
        });

        Schema::table('pull_requests', function (Blueprint $table) {
            $table->renameColumn('github_id', 'provider_id');
        });

        Schema::table('product_backlogs', function (Blueprint $table) {
            $table->renameColumn('github_id', 'provider_id');
        });

        Schema::table('organizations', function (Blueprint $table) {
            $table->renameColumn('github_id', 'provider_id');
        });

        Schema::table('issues', function (Blueprint $table) {
            $table->renameColumn('github_id', 'provider_id');
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->renameColumn('github_id', 'provider_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('provider_id', 'github_id');
        });

        Schema::table('pull_requests', function (Blueprint $table) {
            $table->renameColumn('provider_id', 'github_id');
        });

        Schema::table('product_backlogs', function (Blueprint $table) {
            $table->renameColumn('provider_id', 'github_id');
        });

        Schema::table('organizations', function (Blueprint $table) {
            $table->renameColumn('provider_id', 'github_id');
        });

        Schema::table('issues', function (Blueprint $table) {
            $table->renameColumn('provider_id', 'github_id');
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->renameColumn('provider_id', 'github_id');
        });
    }
}
