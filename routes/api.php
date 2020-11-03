<?php

use Illuminate\Http\Request;

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
Route::namespace('Api')->group(function () {
    Route::get('/users', 'UsersController@index');
    Route::post('/users', 'UsersController@store');
    Route::get('/users/{user}', 'UsersController@show');
    Route::put('/users/{user}', 'UsersController@update');
    Route::delete('/users/{user}', 'UsersController@destroy');

    Route::prefix('/properties')->name('properties.')->group(function () {
        Route::get('/', 'PropertiesController@index')->name('index');
        Route::post('/', 'PropertiesController@store')->name('store');
        Route::get('/{property}', 'PropertiesController@show')->name('show');
        Route::put('/{property}', 'PropertiesController@update')->name('update');
        Route::delete('/{property}', 'PropertiesController@destroy')->name('delete');
    });

    Route::prefix('/contracts')->name('contracts.')->group(function () {
        Route::get('/', 'ContractsController@index')->name('index');
        Route::post('/', 'ContractsController@store')->name('store');
        Route::get('/{contract}', 'ContractsController@show')->name('show');
        Route::put('/{contract}', 'ContractsController@update')->name('update');
        Route::delete('/{contract}', 'ContractsController@destroy')->name('delete');
    });
});

// Route::get('/users', function () {
//     if (rand(1, 10) < 3) {
//         abort(500, 'We could not retrieve the users');
//     }
//     return factory('App\User', 10)->make();
// });

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
