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

Route::get('/test', function(){

	// $posts = App\Models\Purchase::whereHas('lines', function ( $query) {

	// 	dump($query->toSql());

	dd(App\Models\Product::first()->lines);

	// })->get();
	DB::enableQueryLog();
	;
	dd(DB::getQueryLog());
});

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('products')->group(function () {

	Route::get('/', 'ProductController@index');
	Route::post('/{id?}', 'ProductController@store');
	Route::delete('/{id}', 'ProductController@destroy');

	Route::get('/create', 'ProductController@create');
	Route::get('/{id}/edit', 'ProductController@edit');

	// Product Recipes
	Route::get('/{id}/recipes', 'RecipeController@index');
	Route::get('/{id}/recipes/create', 'RecipeController@create');
});

Route::prefix('recipes')->group(function () {

	Route::get('/{id}/edit', 'RecipeController@edit');
	Route::post('/{id?}', 'RecipeController@store');
	Route::delete('/{id}', 'RecipeController@destroy');
});

// Server table data
Route::get('/data', 'ServerTableController@index');

// Select search
Route::get('/search', 'SelectController@index');

Route::prefix('purchases')->group(function () {
	Route::get('/', 'PurchaseController@index');
	Route::get('/create', 'PurchaseController@create');	
	Route::get('/{id}/edit', 'PurchaseController@edit');
	Route::post('/{id?}', 'PurchaseController@store');
	Route::delete('/{id}', 'PurchaseController@destroy');
});