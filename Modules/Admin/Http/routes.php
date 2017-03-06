<?php

Route::group(['middleware' => 'web', 'prefix' => 'admin', 'namespace' => 'Modules\Admin\Http\Controllers'], function()
{
    Route::get('login', ['as' => 'admin.login', 'uses' => 'AdminController@login']);
    Route::post('login', ['as' => 'admin.login', 'uses' => 'AdminController@doLogin']);
    Route::post('logout', ['as' => 'admin.logout', 'uses' => 'AdminController@logout']);
    Route::get('email', ['as' => 'admin.email', 'uses' => 'AdminController@email']);
    Route::get('reset', ['as' => 'admin.reset', 'uses' => 'AdminController@reset']);

});

Route::group(['middleware' => ['web', 'admin'], 'prefix' => 'admin', 'namespace' => 'Modules\Admin\Http\Controllers', 'as' => 'admin.'], function() {
    Route::get('/', ['as' => 'admin.dashboard', 'uses' => 'AdminController@index']);
    Route::resource('users', 'UserController');
    Route::resource('roles', 'RoleController');
});
