<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHoursToNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('notes') && !Schema::hasColumn('notes', 'hours')) {
            Schema::table('notes', function (Blueprint $table) {
                $table->integer('hours')
                       ->unsigned()
                       ->after('position');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('notes') && Schema::hasColumn('notes', 'hours')) {
            Schema::table('notes', function (Blueprint $table) {
                $table->dropColumn('hours');
            });
        }
    }
}
