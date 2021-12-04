<?php

namespace Jecar\Cms\Services;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Jecar\Cms\Controllers\CmsController;
use Jecar\Cms\Models\Page;

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

            Route::get('/', [CmsController::class, 'index'])->name('cms');

            Route::post('/', [CmsController::class, 'store'])->name('cms.create');

            Route::get('/{object}', [CmsController::class, 'show'])->name('cms.show');

            Route::put('/{object}', [CmsController::class, 'update'])->name('cms.update');

            Route::delete('/{object}', [CmsController::class, 'destroy'])->name('cms.delete');

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
        Route::get('/{a}/{b}/{c}', [CmsController::class, 'content']);

        Route::get('/{a}/{b}', [CmsController::class, 'content']);

        Route::get('/{a}', [CmsController::class, 'content']);

        Route::get('/', [CmsController::class, 'content']);

    }

    public function renderPage($path)
    {
        if(!str_starts_with($path, '/')) {
            $path = '/' . $path;
        }

        $page = Page::wherePath($path)->firstOrFail();

        return $page->render();
    }

    private function resourcePath(string $res)
    {
        return __DIR__ . '../../../resources/' . $res;
    }
}
