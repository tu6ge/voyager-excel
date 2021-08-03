<?php 

namespace Tu6ge\VoyagerExcel;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use TCG\Voyager\Facades\Voyager;
use VoyagerExcel\Http\Middleware\VoyagerExcelMiddleware;

class VoyagerExcelServiceProvider extends ServiceProvider
{
    public function register()
    {
        
    }

    public function boot(Router $router, Dispatcher $event)
    {
        $this->loadTranslationsFrom(realpath(__DIR__.'/../resources/lang'), 'voyager_excel');

        Voyager::addAction(\VoyagerExcel\Actions\Export::class);
    }
}