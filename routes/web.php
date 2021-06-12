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
    return view('home');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('products')->group(function () {

	Route::delete('/{id}', 'ProductController@destroy');
	Route::get('/', 'ProductController@index');
	Route::get('/create', 'ProductController@create');
	Route::get('/{id}/edit', 'ProductController@edit');
	Route::post('/{id?}', 'ProductController@store');
});

Route::prefix('recipes')->group(function () {

	Route::delete('/{id}', 'RecipeController@destroy');
	Route::get('/', 'RecipeController@index');
	Route::get('/create', 'RecipeController@create');
	Route::get('/{id}/edit', 'RecipeController@edit');
	Route::post('/{id?}', 'RecipeController@store');
});

// Server table data
Route::get('/data', 'ServerTableController@index');

// Select search
Route::get('/search', 'SelectController@index');

Route::prefix('purchases')->group(function () {
	Route::delete('/{id}', 'PurchaseController@destroy');
	Route::get('/', 'PurchaseController@index');
	Route::get('/create', 'PurchaseController@create');	
	Route::get('/{id}/edit', 'PurchaseController@edit');
	Route::post('/{id?}', 'PurchaseController@store');
});

Route::prefix('sales')->group(function () {
	Route::delete('/{id}', 'SaleController@destroy');
	Route::get('/', 'SaleController@index');
	Route::get('/create', 'SaleController@create');	
	Route::get('/{id}/edit', 'SaleController@edit');
	Route::post('/{id?}', 'SaleController@store');
});

Route::prefix('expenses')->group(function () {

	Route::delete('/{id}', 'ExpenseController@destroy');
	Route::get('/', 'ExpenseController@index');
	Route::get('/create', 'ExpenseController@create');
	Route::get('/{id}/edit', 'ExpenseController@edit');
	Route::post('/{id?}', 'ExpenseController@store');
});

Route::prefix('productions')->group(function () {

	Route::delete('/{id}', 'ProductionController@destroy');
	Route::get('/', 'ProductionController@index');
	Route::get('/create', 'ProductionController@create');
	Route::get('/{id}/edit', 'ProductionController@edit');
	Route::post('/{id?}', 'ProductionController@store');
});

Route::prefix('regularizations')->group(function () {

	Route::delete('/{id}', 'RegularizationController@destroy');
	Route::get('/', 'RegularizationController@index');
	Route::get('/create', 'RegularizationController@create');
	Route::get('/{id}/edit', 'RegularizationController@edit');
	Route::post('/{id?}', 'RegularizationController@store');
});