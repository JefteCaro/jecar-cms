<?php

namespace Jecar\Cms\Providers;

use Illuminate\Support\ServiceProvider as BaseProvider;
use Jecar\Cms\Services\CmsService;
use Jecar\Cms\Console\Commands\PublishMigrations;
use Jecar\Cms\Console\Commands\PublishViews;

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

        $this->commands([
            PublishMigrations::class,
            PublishViews::class,
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

    }

    public function resourcePath(string $res)
    {
        return __DIR__ . '../../../resources/' . $res;
    }
}
