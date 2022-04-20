<?php

use Illuminate\Support\Facades\Route;

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
    return auth()->user();
});

Route::group(['middleware' => ['cors', 'json.response']], function () {

    Route::post('register', 'API\AuthController@register');
    Route::post('login', 'API\AuthController@login');

    Route::middleware('auth:api')->group(function () {
        Route::apiResource('products', 'API\ProductController');
        Route::apiResource('recipes', 'API\RecipeController');
        Route::apiResource('expenses', 'API\ExpenseController');
        Route::apiResource('productions', 'API\ProductionController');
    });
});