<?php

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

Route::any('products/index', 'ProductController@index');
Route::get('products/delete/{id}', 'ProductController@destroy');
Route::post('products/update/{id}', 'ProductController@update');
Route::resource('products','ProductController');

Route::get('/', function () {
    return view('welcome');
});
