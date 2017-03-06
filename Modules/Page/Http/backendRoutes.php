<?php
Route::group(['middleware' => ['web', 'admin'], 'prefix' => 'admin', 'namespace' => 'Modules\Page\Http\Controllers'], function() {
    Route::resource('pages', 'PageAdminController');
});
