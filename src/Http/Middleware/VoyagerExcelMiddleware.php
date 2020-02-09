<?php 

namespace VoyagerExcel\Http\Middleware;

use Closure;
use View;
use Illuminate\View\FileViewFinder;


class VoyagerExcelMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->route()->action['as'] == 'voyager.posts.index'){
            $response = $next($request);
            return response()->view('voyager-excel::browse',$response->original->getData());
        }
        return $next($request);
    }
}