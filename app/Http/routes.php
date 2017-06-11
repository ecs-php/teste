<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'GenericController@noRoute');


Route::group(['prefix'=>'users', 'middleware' => 'AuthBasic'], function() {

	Route::get('/','UsersController@index');
	Route::get('/{id}', 'UsersController@getUser');
 	Route::post('/', 'UsersController@createUser');
 	Route::put('/{id}', 'UsersController@updateUser');
 	Route::delete('/{id}', 'UsersController@deleteUser');

});