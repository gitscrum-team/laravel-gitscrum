<?php

abstract class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    use DatabaseMigrations;

    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = null;

    protected $visitUrl = '/';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        if(defined('HHVM_VERSION'))
        {
            $this->markTestSkipped('must be revisited.');
        }

        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        $this->baseUrl = env('APP_URL');

        return $app;
    }

    public function setUp()
    {
        parent::setUp();
        $this->initDatabase();

        $user = \GitScrum\Models\User::find(1);
        $this->be($user);
    }

    protected function tearDown()
    {
        //fwrite(STDOUT, __METHOD__ . "\n");
    }
}
