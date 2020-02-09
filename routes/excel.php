<?php 

$namespacePrefix = '\\VoyagerExcel\Http\Controllers\\';


Route::get('excel/posts/export', ['uses'=> $namespacePrefix.'PostController@index','as'=>'excel.post']);
