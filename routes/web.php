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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('movies', 'MovieController@index')->name('movies.index');
Route::get('movies/create', 'MovieController@create')->name('movies.create');
Route::get('movies/{id}', 'MovieController@show')->where('id', '[0-9]+')->name('movies.show');
Route::post('movies', 'MovieController@store')->name('movies.store');
Route::get('movies/{id}/edit', 'MovieController@edit')->name('movies.edit');
Route::patch('movies/{id}', 'MovieController@update')->name('movies.update');
Route::delete('movies/{id}', 'MovieController@destroy')->name('movies.destroy');
Route::get('movies/search', 'MovieController@search')->name('movies.search');
Route::get('movies/filter', 'MovieController@filter')->name('movies.filter');