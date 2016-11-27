<?php

use Illuminate\Database\Seeder;

class ConfigIssueEffortsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run()
    {
        \DB::table('config_issue_efforts')->delete();

        \DB::table('config_issue_efforts')->insert([
            0 => [
                'id'       => 1,
                'title'    => '0',
                'effort'   => '0.00',
                'position' => 0,
                'enabled'  => 1,
            ],
            1 => [
                'id'       => 2,
                'title'    => '1',
                'effort'   => '1.00',
                'position' => 2,
                'enabled'  => 1,
            ],
            2 => [
                'id'       => 3,
                'title'    => '2',
                'effort'   => '2.00',
                'position' => 3,
                'enabled'  => 1,
            ],
            3 => [
                'id'       => 4,
                'title'    => '3',
                'effort'   => '3.00',
                'position' => 4,
                'enabled'  => 1,
            ],
            4 => [
                'id'       => 5,
                'title'    => '5',
                'effort'   => '5.00',
                'position' => 5,
                'enabled'  => 1,
            ],
            5 => [
                'id'       => 6,
                'title'    => '8',
                'effort'   => '8.00',
                'position' => 6,
                'enabled'  => 1,
            ],
            6 => [
                'id'       => 7,
                'title'    => '13',
                'effort'   => '13.00',
                'position' => 7,
                'enabled'  => 1,
            ],
            7 => [
                'id'       => 8,
                'title'    => '21',
                'effort'   => '21.00',
                'position' => 8,
                'enabled'  => 1,
            ],
            8 => [
                'id'       => 9,
                'title'    => '34',
                'effort'   => '34.00',
                'position' => 9,
                'enabled'  => 1,
            ],
            9 => [
                'id'       => 10,
                'title'    => '55',
                'effort'   => '55.00',
                'position' => 10,
                'enabled'  => 1,
            ],
            10 => [
                'id'       => 11,
                'title'    => '89',
                'effort'   => '89.00',
                'position' => 11,
                'enabled'  => 1,
            ],
            11 => [
                'id'       => 12,
                'title'    => '1/2',
                'effort'   => '0.50',
                'position' => 1,
                'enabled'  => 1,
            ],
        ]);
    }
}
