<?php

use GitScrum\Models\User;
use GitScrum\Classes\Helper;

class UserTest extends TestCase
{
    public function test_list_product_backlog()
    {
        // should check if the user has some product backlog
        $productBacklogs = Auth::user()->productBacklogs();
        $this->assertGreaterThan(0, $productBacklogs->count());

        $paginate = Helper::lengthAwarePaginator($productBacklogs, 1);
        $this->assertTrue(is_object($paginate->links()));

        // should return first page collection
        $paginate = Helper::lengthAwarePaginator($productBacklogs, 'nothing');
        $this->assertTrue(is_object($paginate->links()));
    }

    public function test_list_user_story()
    {
        $userStories = Auth::user()->userStories();
        $this->assertGreaterThan(0, $userStories->count());

        $paginate = Helper::lengthAwarePaginator($userStories, 1);
        $this->assertTrue(is_object($paginate->links()));

        // should return first page collection
        $paginate = Helper::lengthAwarePaginator($userStories, 'nothing');
        $this->assertTrue(is_object($paginate->links()));
    }
}
