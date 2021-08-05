<?php

namespace Tu6ge\VoyagerExcel;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use TCG\Voyager\Facades\Voyager;

class VoyagerExcelServiceProvider extends ServiceProvider
{
    public function register()
    {
    }

    public function boot(Router $router, Dispatcher $event)
    {
        $this->loadTranslationsFrom(realpath(__DIR__.'/../resources/lang'), 'voyager_excel');

        Voyager::addAction(\Tu6ge\VoyagerExcel\Actions\Export::class);
    }
}
