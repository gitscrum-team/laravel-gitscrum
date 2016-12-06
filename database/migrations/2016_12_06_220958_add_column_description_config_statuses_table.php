<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnDescriptionConfigStatusesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('config_statuses', function (Blueprint $table) {
            $table->string('description', 120)->nullable()->after('title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('config_statuses', function (Blueprint $table) {
            $table->dropColumn('description');
        });
    }
}
