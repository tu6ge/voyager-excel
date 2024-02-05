<?php

namespace themachinarium\MacherExcel;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use MCH\Macher\Facades\Macher;

class MacherExcelServiceProvider extends ServiceProvider
{
    public function register()
    {
    }

    public function boot(Router $router, Dispatcher $event)
    {
        $this->loadTranslationsFrom(realpath(__DIR__.'/../resources/lang'), 'macher_excel');

        Macher::addAction(\themachinarium\MacherExcel\Actions\Export::class);
    }
}
