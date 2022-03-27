<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Product;

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

Route::group(['middleware' => ['cors', 'json.response']], function () {

    // Route::post('register', 'API\AuthController@register');
    // Route::post('login', 'API\AuthController@login');

    Route::middleware('auth:api')->group(function () {
        Route::apiResource('products', 'API\ProductController');
    });
});

// Route::get('products', function() {
//     $instances = Product::all();

//         return response(['instances' => $instances]);
// });