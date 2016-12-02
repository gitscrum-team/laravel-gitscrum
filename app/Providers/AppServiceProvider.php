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

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Relation::morphMap(\Config::get('database.relation'));
    }

    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->bind('GithubClass', function()
        {
            return new Github;
        });
    }

    public function provides()
    {
        return ['GithubClass'];
    }
}
