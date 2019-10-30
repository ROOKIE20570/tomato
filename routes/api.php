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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'cost'], function () {
    Route::get('/{id}','CostController@getOne');
    Route::get('/','CostController@getCosts');
    Route::post('/','CostController@addCost');
    Route::put('/{id}','CostController@updateCost');
    Route::delete('/{id}','CostController@delete');
});

Route::group(['prefix' => 'task'], function () {
    Route::get('/{id}','TaskController@getOne');
    Route::get('/','TaskController@getTasks');
    Route::post('/','TaskController@addTask');
    Route::put('/{id}','TaskController@updateTask');
    Route::delete('/{id}','TaskController@delete');
    Route::put('/trigger/{id}','TaskController@trigger');
    Route::put('/deal','TaskController@dealTask')->name('dealTask');
});

