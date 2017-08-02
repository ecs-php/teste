<?php

$api = $app['controllers_factory'];

$ctrl = 'BookStore\Controllers\ApiController';


$api->before("$ctrl::authentication");

$api->put('book/{id}', "$ctrl::update");

$api->post('book', "$ctrl::insert");

$api->delete('book/{id}', "$ctrl::delete");

$api->get('books', "$ctrl::all");


$app->mount('api', $api);
