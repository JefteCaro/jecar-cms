<?php

namespace Jecar\Cms\Providers;

use Illuminate\Support\ServiceProvider as BaseProvider;
use Jecar\Cms\Services\CmsService;
use Jecar\Cms\Console\Commands\PublishMigrations;

class ServiceProvider extends BaseProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->alias(CmsService::class, 'jecar-cms');

        $this->publishables();

        $this->commands([
            PublishMigrations::class,
        ]);

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    public function publishables()
    {
        $this->publishes([
            $this->resourcePath('config/jecar-cms.php') => \config_path('jecar-cms.php')
        ], 'jecar.cms.config');

    }

    public function resourcePath(string $res)
    {
        return __DIR__ . '../../resources/' . $res;
    }
}
