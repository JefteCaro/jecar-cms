<?php

namespace Jecar\Cms\Services;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Jecar\Cms\Controllers\CmsController;
use Jecar\Cms\Controllers\MediaController;
use Jecar\Cms\Controllers\PageController;
use Jecar\Cms\Controllers\TemplateController;
use Jecar\Cms\Models\Page;
use Jecar\Core\Services\JecarService;

class CmsService extends JecarService
{
    public function buildRoutes()
    {
        Route::group(['prefix' => $this->config['paths']['cms']], function() {

            Route::get('/', [CmsController::class, 'index'])->name('cms');

            Route::group(['prefix' => 'pages', 'as' => 'pages'], function() {
                Route::get('/', [PageController::class, 'index'])->name('');
                Route::post('/', [PageController::class, 'store'])->name('.create');
                Route::get('/{page}', [PageController::class, 'show'])->name('.show');
                Route::put('/{page}', [PageController::class, 'update'])->name('.update');
                Route::delete('/{page}', [PageController::class, 'delete'])->name('.delete');
            });

            Route::group(['prefix' => 'media', 'as' => 'media'], function() {
                Route::get('/', [MediaController::class, 'index'])->name('');
                Route::post('/', [MediaController::class, 'store'])->name('.create');
                Route::get('/{media}', [MediaController::class, 'show'])->name('.show');
                Route::put('/{media}', [MediaController::class, 'update'])->name('.update');
                Route::delete('/{media}', [MediaController::class, 'delete'])->name('.delete');
            });

            Route::group(['prefix' => 'templates', 'as' => '.templates'], function() {
                Route::get('/', [TemplateController::class, 'index'])->name('');
                Route::post('/', [TemplateController::class, 'store'])->name('.create');
                Route::get('/{template}', [TemplateController::class, 'show'])->name('.show');
                Route::put('/{template}', [TemplateController::class, 'update'])->name('.update');
                Route::delete('/{template}', [TemplateController::class, 'delete'])->name('.delete');
            });


        });
    }

    public function adminRoutes()
    {
        if(isset($this->config['subdomains']['cms']) && strlen($this->config['subdomains']['cms']) > 0) {
            Route::domain($this->config['subdomains']['cms'] . '.' . config('app.url'))->group(function() {
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
}
