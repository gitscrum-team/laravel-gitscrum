<?php

use Illuminate\Database\Seeder;

class ConfigPrioritiesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run()
    {
        \DB::table('config_priorities')->delete();

        \DB::table('config_priorities')->insert(array(
            0 => array(
                'id' => 1,
                'slug' => 'must-have',
                'type' => 'user_story',
                'title' => 'Must have',
                'description' => 'features that must be included before the product can be launched. It is good to have clarity on this before a project begins, as this is the minimum scope for the product to be useful.',
                'color' => 'ED1B35',
                'position' => 0,
                'enabled' => 1,
            ),
            1 => array(
                'id' => 2,
                'slug' => 'should-have',
                'type' => 'user_story',
                'title' => 'Should have',
                'description' => 'features that are not critical to launch, but are considered to be important and of a high value to the user.',
                'color' => 'F58631',
                'position' => 1,
                'enabled' => 1,
            ),
            2 => array(
                'id' => 3,
                'slug' => 'could-have',
                'type' => 'user_story',
                'title' => 'Could have',
                'description' => 'features that are nice to have and could potentially be included without incurring too much effort or cost. These will be the first features to be removed from scope if the project’s timescales are later at risk.',
                'color' => '8E479C',
                'position' => 2,
                'enabled' => 1,
            ),
            3 => array(
                'id' => 4,
                'slug' => 'wont-have',
                'type' => 'user_story',
                'title' => 'Won’t have',
                'description' => 'features that have been reqeusted but are explicitly excluded from scope for the planned duration, and may be included in a future phase of development.',
                'color' => 'A1A2A3',
                'position' => 3,
                'enabled' => 1,
            ),
        ));
    }
}
