<?php

Route::group(['middleware' => 'web', 'namespace' => 'Modules\Page\Http\Controllers'], function() {
    Route::get('/pages', 'PageController@index');
});
