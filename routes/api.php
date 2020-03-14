<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:api')->group(function () {

	Route::get('/user', 'ApiUserController@show');
	Route::patch('/user-email', 'ApiUserController@updateEmail');
	Route::patch('/user-password', 'ApiUserController@updatePassword');
	Route::patch('/user-options', 'ApiUserOptionsController@update');

    Route::get('movies', 'ApiMovieController@index');
	Route::get('movies/{movie}', 'ApiMovieController@show')->where('movie', '[0-9]+');
	Route::post('movies', 'ApiMovieController@store');
	Route::patch('movies/{movie}', 'ApiMovieController@update');
	Route::delete('movies/{movie}', 'ApiMovieController@destroy');
	Route::get('movies/search', 'ApiMovieController@filter');

});

Route::post('/login', 'AuthController@login');
Route::post('/register', 'AuthController@register');
Route::post('/password/email', 'AuthController@linkEmail');
Route::post('/password/reset', 'AuthController@reset');
Route::middleware('auth:api')->post('/logout', 'AuthController@logout');
Route::post('/refresh-login', 'AuthController@refreshToken');
