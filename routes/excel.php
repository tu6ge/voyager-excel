<?php 



Route::group(['as'=>'voyager_excel.'], function(){
    $namespacePrefix = '\\VoyagerExcel\Http\Controllers\\';
    Route::get('excel/posts/export', ['uses'=> $namespacePrefix.'PostController@index'])->name('export.post');
});

