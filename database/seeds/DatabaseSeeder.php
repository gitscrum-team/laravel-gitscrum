<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(ConfigIssueEffortsTableSeeder::class);
        $this->call(ConfigPrioritiesTableSeeder::class);
        $this->call(IssueTypesTableSeeder::class);
        $this->call('ConfigStatusesTableSeeder');
    }
}
