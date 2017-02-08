<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

/**
 * Welcome message
 *
 *
 * @return Response
 */
$app->get('/', function () use ($app) {
	echo 'Contacts' . '<br>';
	echo 'Developer: Caio Santos' . '<br>';
	echo 'Email: santoscaio@gmail.com' . '<br>';
});

$app->group(['prefix'=>'contact/', 'middleware' => 'BasicAuth', 'namespace' => 'App\Http\Controllers'], function($app) {
    $app->get('/{id}', 'contactController@select');
    $app->post('/', 'contactController@insert');
    $app->put('/{id}', 'contactController@update');
    $app->delete('/{id}', 'contactController@delete');
});

