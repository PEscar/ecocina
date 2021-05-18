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

	// Recipes
	Route::get('/{id}/recipes', 'RecipeController@index');

	Route::get('/{id}/recipes/create', 'RecipeController@create');
});

Route::prefix('recipes')->group(function () {

	Route::get('/{id}/edit', 'RecipeController@edit');
	Route::post('/{id?}', 'RecipeController@store');
	Route::delete('/{id}', 'RecipeController@destroy');
});