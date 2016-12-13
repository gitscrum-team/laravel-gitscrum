<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnGithubIdCommentsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->bigInteger('github_id')->nullable()->unique()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropColumn('github_id');
        });
    }
}
