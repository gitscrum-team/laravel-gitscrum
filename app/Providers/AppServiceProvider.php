<?php
/**
 * GitScrum v0.1.
 *
 * @author  Renato Marinho <renato.marinho@s2move.com>
 * @license http://opensource.org/licenses/GPL-3.0 GPLv3
 */

namespace GitScrum\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;
use GitScrum\Classes\Github;
use GitScrum\Classes\Gitlab;
use Config;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Relation::morphMap(Config::get('database.relation'));
    }

    /**
     * Register any application services.
     */
    public function register()
    {
        foreach (Config::get('app.services') as $service) {
            $this->app->singleton($service, function () use ($service) {
                $namespace = 'GitScrum\\Services\\' . $service;
                return new $namespace();
            });
        }

        $this->app->singleton('Github', function () {
            return new Github();
        });

        $this->app->singleton('Gitlab', function () {
            return new Gitlab();
        });
    }

    public function provides()
    {
        return ['Github', 'Gitlab'];
    }
}
