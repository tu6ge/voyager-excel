<?php 

namespace VoyagerExcel\Http\ViewComposers;

use Illuminate\View\View;

class ExcelComposer 
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('count', 1);
    }
}