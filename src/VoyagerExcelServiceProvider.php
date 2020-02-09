<?php 

namespace VoyagerExcel;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use VoyagerExcel\Http\Middleware\VoyagerExcelMiddleware;

class VoyagerExcelServiceProvider extends ServiceProvider
{
    public function register()
    {
        
    }

    public function boot(Router $router, Dispatcher $event)
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/excel.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'voyager-excel');

        
        $router->aliasMiddleware('voyager.excel', VoyagerExcelMiddleware::class);
    }
}