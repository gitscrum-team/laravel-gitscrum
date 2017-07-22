<?php


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'config-status'], function () {
    Route::post('/update-position', 'Web\ConfigStatusController@updatePosition')->name('api.configStatus.position.update');
});
