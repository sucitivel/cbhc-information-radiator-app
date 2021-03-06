<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['web']], function () {
    Route::get('/', 'App\Http\Controllers\DashboardController@index')->name('dashboard.index');

    Route::get('/rooms', 'App\Http\Controllers\RoomController@index')->name('room.index');

    Route::get('/room/{room}', 'App\Http\Controllers\RoomController@show')->name('room.show');

    Route::get('/oauth2', 'App\Http\Controllers\Oauth2Controller@receiveToken')->name('oauth2.receiveToken');
});
