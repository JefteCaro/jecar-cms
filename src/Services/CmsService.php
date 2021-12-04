<?php

namespace Jecar\Cms\Services;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Jecar\Cms\Controllers\CmsController;

class CmsService
{
    private $config;

    public function __construct()
    {
        $this->config = Config::get('jecar-cms', require($this->resourcePath('config/jecar-cms.php')));
    }

    public function buildRoutes()
    {
        Route::group(['prefix' => $this->config['app']['path']], function() {

            Route::get('/', [CmsController::class, 'index']);

            Route::get('/{object}', [CmsController::class, 'index']);

        });
    }

    public function adminRoutes()
    {
        if(isset($this->config['app']['subdomain'])) {
            Route::domain($this->config['app']['subdomain'] . '.' . config('app.url'))->group(function() {
                $this->buildRoutes();
            });
        } else {
            $this->buildRoutes();
        }
    }

    public function publicRoutes()
    {
        Route::get('/{group}/{path}', function() {
            return 'public';
        });

        Route::get('/{path}', function() {
            return 'public';
        });

    }

    private function resourcePath(string $res)
    {
        return __DIR__ . '../../resources/' . $res;
    }
}
