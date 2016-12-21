<?php

trait DatabaseMigrations
{
    public function runDatabaseMigrations()
    {
        shell_exec('touch '.storage_path().'/framework/cache/database.sqlite');
        $this->artisan('migrate');
        $this->artisan('db:seed');

        $this->beforeApplicationDestroyed(function () {
            $this->artisan('migrate:rollback');
            shell_exec('rm '.storage_path().'/framework/cache/database.sqlite');
        });
    }
}
