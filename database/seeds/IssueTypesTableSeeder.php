<?php

use Illuminate\Database\Seeder;

class IssueTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('issue_types')->delete();
        
        \DB::table('issue_types')->insert(array (
            0 => 
            array (
                'id' => 1,
                'parent_id' => NULL,
                'slug' => 'new-feature',
                'code' => 'NFEA',
                'title' => 'New Feature ',
                'description' => 'A new feature of the product, which has yet to be developed.',
                'color' => 'F15A29',
                'position' => 4,
                'enabled' => 1,
            ),
            1 => 
            array (
                'id' => 2,
                'parent_id' => NULL,
                'slug' => 'bug',
                'code' => 'BUG',
                'title' => 'Bug',
                'description' => 'A problem which impairs or prevents the functions of the product.',
                'color' => 'D91821',
                'position' => 1,
                'enabled' => 1,
            ),
            2 => 
            array (
                'id' => 3,
                'parent_id' => NULL,
                'slug' => 'task',
                'code' => 'TASK',
                'title' => 'Task',
                'description' => 'A task that needs to be done.',
                'color' => 'FFD00A',
                'position' => 2,
                'enabled' => 1,
            ),
            3 => 
            array (
                'id' => 4,
                'parent_id' => NULL,
                'slug' => 'improvement',
                'code' => 'IMPR',
                'title' => 'Improvement',
                'description' => 'An improvement or enhancement to an existing feature or task.',
                'color' => '54C2BC',
                'position' => 0,
                'enabled' => 1,
            ),
            4 => 
            array (
                'id' => 5,
                'parent_id' => NULL,
                'slug' => 'support-request ',
                'code' => 'SRES',
                'title' => 'Support Request',
                'description' => 'Issue that is likely specific to the installation',
                'color' => '31BEF3',
                'position' => 0,
                'enabled' => 1,
            ),
            5 => 
            array (
                'id' => 6,
                'parent_id' => NULL,
                'slug' => 'third-party-issue ',
                'code' => 'TPAR',
                'title' => 'Third-party issue ',
            'description' => 'An issue relating to a third-party product (eg. app server) that nevertheless affects this product',
                'color' => '4FB94A',
                'position' => 0,
                'enabled' => 1,
            ),
            6 => 
            array (
                'id' => 7,
                'parent_id' => NULL,
                'slug' => 'request ',
                'code' => 'REQU',
                'title' => 'Request ',
                'description' => 'A User Request',
                'color' => '4EA4DA',
                'position' => 0,
                'enabled' => 1,
            ),
            7 => 
            array (
                'id' => 8,
                'parent_id' => NULL,
                'slug' => 'feedback',
                'code' => 'FBAC',
                'title' => 'Feedback',
                'description' => NULL,
                'color' => '8A65AE',
                'position' => 0,
                'enabled' => 1,
            ),
            8 => 
            array (
                'id' => 9,
                'parent_id' => NULL,
                'slug' => 'customer-problem',
                'code' => 'CUST',
                'title' => 'Customer Problem ',
                'description' => 'A general description of a customer problem',
                'color' => 'E20492',
                'position' => 0,
                'enabled' => 1,
            ),
            9 => 
            array (
                'id' => 10,
                'parent_id' => NULL,
                'slug' => 'infrastructure',
                'code' => 'INFR',
                'title' => 'Infrastructure',
                'description' => NULL,
                'color' => 'CD6AA9',
                'position' => 0,
                'enabled' => 1,
            ),
            10 => 
            array (
                'id' => 11,
                'parent_id' => NULL,
                'slug' => 'marketing-request',
                'code' => 'MARK',
                'title' => 'Marketing Request',
                'description' => 'Request for a blog post, event, or campaign assistance',
                'color' => 'F78232',
                'position' => 0,
                'enabled' => 1,
            ),
            11 => 
            array (
                'id' => 12,
                'parent_id' => NULL,
                'slug' => 'documentation',
                'code' => 'DOCU',
                'title' => 'Documentation',
                'description' => NULL,
                'color' => '008AD5',
                'position' => 0,
                'enabled' => 1,
            ),
            12 => 
            array (
                'id' => 13,
                'parent_id' => NULL,
                'slug' => 'experiment',
                'code' => 'EXPE',
                'title' => 'Experiment',
                'description' => NULL,
                'color' => 'E66524',
                'position' => 0,
                'enabled' => 1,
            ),
            13 => 
            array (
                'id' => 14,
                'parent_id' => NULL,
                'slug' => 'ux',
                'code' => 'UX',
                'title' => 'UX',
                'description' => 'A user experience task',
                'color' => '2C559A',
                'position' => 0,
                'enabled' => 1,
            ),
            14 => 
            array (
                'id' => 15,
                'parent_id' => NULL,
                'slug' => 'testing-task',
                'code' => 'TEST',
                'title' => 'Testing Task',
                'description' => NULL,
                'color' => 'B32929',
                'position' => 0,
                'enabled' => 1,
            ),
            15 => 
            array (
                'id' => 16,
                'parent_id' => NULL,
                'slug' => 'event',
                'code' => 'EVEN',
                'title' => 'Event',
                'description' => 'Analytics event',
                'color' => '6D876A',
                'position' => 0,
                'enabled' => 1,
            ),
            16 => 
            array (
                'id' => 17,
                'parent_id' => NULL,
                'slug' => 'qa-task ',
                'code' => 'QATA',
                'title' => 'QA Task',
                'description' => '',
                'color' => '6E4849',
                'position' => 0,
                'enabled' => 1,
            ),
        ));
        
        
    }
}
