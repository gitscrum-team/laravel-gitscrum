<?php

use GitScrum\Models\ConfigStatus;
use GitScrum\Models\Sprint;
use Carbon\Carbon;

class SprintTest extends TestCase
{

    public function test_create_sprint()
    {
        $faker = Faker\Factory::create();

        $dateStart = Carbon::now()->addDays(2);
        $dateFinish = Carbon::now()->addDays(16);

        $data = [
            'product_backlog_id' => 1,
            'title' => 'sprint'.mt_rand(1,20),
            'description' => $faker->sentence(mt_rand(10, 20)),
            'date_start' => $dateStart->toDateTimeString(),
            'date_finish' => $dateFinish->toDateTimeString()
        ];

        $sprint = Sprint::create($data);
        $this->assertEquals($data['title'], $sprint->title);
    }

    public function test_config_status_id_default()
    {
        $configStatusId = ConfigStatus::type('sprint')->default()->first()->id;

        $sprint = Sprint::first();

        $this->assertEquals($sprint->config_status_id, $configStatusId);
    }

    public function test_config_status_id_change_to_open()
    {
        $configStatusId = ConfigStatus::type('sprint')->where('is_closed', null)->first()->id;

        $sprint = Sprint::first();
        $sprint->config_status_id = $configStatusId;
        $sprint->save();

        $this->assertNull($sprint->closed_at);
    }

    public function test_list_total()
    {
        $sprints = Sprint::all();
        $this->assertGreaterThan(0, $sprints->count());
    }

}
