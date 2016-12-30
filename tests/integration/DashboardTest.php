<?php

class DashboardTest extends TestCase
{
    public function _construct()
    {
        $this->visitUrl = '/dashboard';
    }

    public function test_dashboard_status()
    {
        $this->visit($this->visitUrl)
            ->assertResponseOk();
    }

    public function test_add_quick_note()
    {
        $faker = Faker\Factory::create();

        $title = $faker->sentence(mt_rand(10, 16));

        $this->visit($this->visitUrl)
            ->see('<div class="notes">')
            ->type($title, 'frm_notes_title')
            ->press('Add')
            ->seeInDatabase('notes', ['title' => $title]);
    }

    public function test_message_empty_sprint_member()
    {
        $this->visit($this->visitUrl)
            ->see('list-sprint-empty');
    }
}
