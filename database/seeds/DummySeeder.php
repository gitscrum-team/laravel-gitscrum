<?php

use Illuminate\Database\Seeder;

class DummySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        (new SettingSeeder)->run();
    }

    private function delete()
    {
    }
}
