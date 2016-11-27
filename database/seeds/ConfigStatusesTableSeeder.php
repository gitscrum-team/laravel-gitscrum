<?php

use Illuminate\Database\Seeder;

class ConfigStatusesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run()
    {
        \DB::table('config_statuses')->delete();

        \DB::table('config_statuses')->insert(array(
            0 => array(
                'id' => 1,
                'slug' => 'todo',
                'type' => 'issue',
                'title' => 'Todo',
                'position' => 1,
                'color' => 'daa724',
                'is_closed' => null,
                'default' => 1,
            ),
            1 => array(
                'id' => 2,
                'slug' => 'in-progress',
                'type' => 'issue',
                'title' => 'In Progress',
                'position' => 2,
                'color' => '079a0d',
                'is_closed' => null,
                'default' => null,
            ),
            2 => array(
                'id' => 3,
                'slug' => 'done',
                'type' => 'issue',
                'title' => 'Done',
                'position' => 3,
                'color' => '3745be',
                'is_closed' => 1,
                'default' => null,
            ),
            3 => array(
                'id' => 4,
                'slug' => 'archived',
                'type' => 'issue',
                'title' => 'Arquived',
                'position' => 4,
                'color' => '8c023f',
                'is_closed' => 1,
                'default' => null,
            ),
            4 => array(
                'id' => 5,
                'slug' => 'updated',
                'type' => 'note',
                'title' => 'Updated',
                'position' => 0,
                'color' => 'f0f0f0',
                'is_closed' => null,
                'default' => 1,
            ),
            5 => array(
                'id' => 6,
                'slug' => 'open',
                'type' => 'sprint',
                'title' => 'Open',
                'position' => 1,
                'color' => '079a0d',
                'is_closed' => null,
                'default' => 1,
            ),
            6 => array(
                'id' => 7,
                'slug' => 'closed',
                'type' => 'sprint',
                'title' => 'Closed',
                'position' => 3,
                'color' => '3745be',
                'is_closed' => 1,
                'default' => null,
            ),
            7 => array(
                'id' => 8,
                'slug' => 'standby',
                'type' => 'sprint',
                'title' => 'Standby',
                'position' => 2,
                'color' => '8c023f',
                'is_closed' => null,
                'default' => null,
            ),
            8 => array(
                'id' => 9,
                'slug' => 'attachment-added',
                'type' => 'attachment',
                'title' => 'Added',
                'position' => 1,
                'color' => '6272a4',
                'is_closed' => null,
                'default' => null,
            ),
        ));
    }
}
