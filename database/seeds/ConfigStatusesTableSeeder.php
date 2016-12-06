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
                'slug' => 'issue-todo',
                'type' => 'issue',
                'title' => 'Todo',
                'description' => 'changed status to "todo"',
                'position' => 1,
                'color' => 'daa724',
                'is_closed' => null,
                'default' => 1,
            ),
            1 => array(
                'id' => 2,
                'slug' => 'issue-in-progress',
                'type' => 'issue',
                'description' => 'changed status to "in progress"',
                'title' => 'In Progress',
                'position' => 2,
                'color' => '079a0d',
                'is_closed' => null,
                'default' => null,
            ),
            2 => array(
                'id' => 3,
                'slug' => 'issue-done',
                'type' => 'issue',
                'title' => 'Done',
                'description' => 'changed status to "done"',
                'position' => 3,
                'color' => '3745be',
                'is_closed' => 1,
                'default' => null,
            ),
            3 => array(
                'id' => 4,
                'slug' => 'issue-archived',
                'type' => 'issue',
                'title' => 'Arquived',
                'description' => 'changed status to "arquived"',
                'position' => 4,
                'color' => '8c023f',
                'is_closed' => 1,
                'default' => null,
            ),
            4 => array(
                'id' => 5,
                'slug' => 'note-added',
                'type' => 'note',
                'title' => 'added',
                'description' => 'added a note',
                'position' => 0,
                'color' => 'f0f0f0',
                'is_closed' => null,
                'default' => 1,
            ),
            5 => array(
                'id' => 6,
                'slug' => 'sprint-open',
                'type' => 'sprint',
                'title' => 'Open',
                'description' => 'open a sprint',
                'position' => 1,
                'color' => '079a0d',
                'is_closed' => null,
                'default' => 1,
            ),
            6 => array(
                'id' => 7,
                'slug' => 'sprint-closed',
                'type' => 'sprint',
                'title' => 'Closed',
                'description' => 'closed a sprint',
                'position' => 3,
                'color' => '3745be',
                'is_closed' => 1,
                'default' => null,
            ),
            7 => array(
                'id' => 8,
                'slug' => 'sprint-standby',
                'type' => 'sprint',
                'title' => 'Standby',
                'description' => 'standby a sprint',
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
                'description' => 'added an attachment',
                'position' => 1,
                'color' => '6272a4',
                'is_closed' => null,
                'default' => 1,
            ),
            9 => array(
                'id' => 10,
                'slug' => 'commented-added',
                'type' => 'comment',
                'title' => 'Commented',
                'description' => 'added a comment',
                'position' => 1,
                'color' => '3745be',
                'is_closed' => null,
                'default' => 1,
            ),
            10 => array(
                'id' => 11,
                'slug' => 'label-assigned',
                'type' => 'label',
                'title' => 'Assigned',
                'description' => 'assigned a label',
                'position' => 1,
                'color' => '3745be',
                'is_closed' => null,
                'default' => 1,
            ),
        ));
    }
}
