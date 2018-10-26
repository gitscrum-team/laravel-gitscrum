<?php

use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $this->delete();
        $this->call(ConfigIssueEffortsTableSeeder::class);
        $this->call(ConfigPrioritiesTableSeeder::class);
        $this->call(IssueTypesTableSeeder::class);
        $this->call(ConfigStatusesTableSeeder::class);
    }

    private function delete()
    {
        //
    }
}
