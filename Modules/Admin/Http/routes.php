<?php

Route::group(['middleware' => 'web', 'prefix' => 'admin', 'namespace' => 'Modules\Admin\Http\Controllers'], function()
{
    Route::get('login', ['as' => 'admin.login', 'uses' => 'AdminController@login']);
    Route::get('email', ['as' => 'admin.email', 'uses' => 'AdminController@email']);
    Route::get('reset', ['as' => 'admin.reset', 'uses' => 'AdminController@reset']);

});

Route::group(['middleware' => ['web', 'admin'], 'prefix' => 'admin', 'namespace' => 'Modules\Admin\Http\Controllers'], function() {
    Route::get('/', ['as' => 'admin.dashboard', 'uses' => 'AdminController@index']);
});
