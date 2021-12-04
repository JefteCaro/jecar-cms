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

        $this->loadViewsFrom(
            $this->viewGroups(), 'jecar'
        );

        $this->commands([
            PublishMigrations::class,
            PublishViews::class,
        ]);

    }

    public function viewGroups()
    {
        if(file_exists(resource_path('views/vendor/cms/cms.blade.php'))) {
            return resource_path('views/vendor/cms');
        }
        return  $this->resourcePath('views');
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
