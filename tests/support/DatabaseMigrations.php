<?php

trait DatabaseMigrations
{
    protected static $dbInited = false;

    public function initDatabase()
    {
        if (!self::$dbInited) {
            fwrite(STDOUT, 'Preparing database'."\n");
            $this->artisan('migrate:refresh');
            $this->artisan('db:seed');
            $user = $this->createUser();
            $this->createOrganization()->users()->sync([$user->id]);
            $this->createProductBacklog();
            self::$dbInited = true;
        }
    }

    private function createOrganization()
    {
        $faker = Faker\Factory::create();

        $data = [
            'provider_id' => $faker->randomNumber,
            'provider' => 'github',
            'username' => 'Laravel-GitScrum',
            'email' => $faker->email,
        ];

        return \GitScrum\Models\Organization::create($data);
    }

    private function createUser()
    {
        $faker = Faker\Factory::create();

        $data = [
            'provider_id' => $faker->randomNumber,
            'provider' => 'github',
            'name' => $faker->name,
            'username' => $faker->username,
            'email' => $faker->email,
            'avatar' => $faker->imageUrl(600, 600, 'people', true, 'Faker'),
        ];

        return \GitScrum\Models\User::create($data);
    }

    private function createProductBacklog()
    {
        $faker = Faker\Factory::create();

        $data = [
            'provider_id' => $faker->randomNumber,
            'provider' => 'github',
            'user_id' => \GitScrum\Models\User::first()->id,
            'organization_id' => \GitScrum\Models\Organization::first()->id,
            'title' => 'laravel-gitscrum',
            'description' => 'Laravel GitScrum is a free application to help developer team. Git + Scrum = Team More Productive',
            'fullname' => 'renatomarinho/laravel-gitscrum',
            'since' => \Carbon\Carbon::now()->toDateTimeString(),
        ];

        return \GitScrum\Models\ProductBacklog::create($data);
    }
}
