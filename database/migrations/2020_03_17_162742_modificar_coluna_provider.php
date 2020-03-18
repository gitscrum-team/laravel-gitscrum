<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModificarColunaProvider extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN provider VARCHAR(120) NOT NULL DEFAULT 'local' ");
        DB::statement("ALTER TABLE users MODIFY COLUMN provider_id VARCHAR(255) NULL");

        DB::statement("ALTER TABLE users ADD COLUMN active INT NOT NULL DEFAULT 0");

        DB::statement("ALTER TABLE organizations MODIFY COLUMN provider VARCHAR(120) NOT NULL DEFAULT 'local' ");

        DB::statement("ALTER TABLE issues MODIFY COLUMN provider VARCHAR(120) NOT NULL DEFAULT 'local' ");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
