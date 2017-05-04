<?php

$user = $app['controllers_factory'];

use Symfony\Component\Console\Application;
use Symfony\Component\HttpFoundation\Request;

$user->before(function (Request $request, Application $app) { 
    
});

$user->get('/', function () {return 'test';});
$user->post('/', function () {return 'test';});
$user->post('/authenticate', function () {return 'test';});
$user->put('/:id', function () {return 'test';});
$user->delete('/:id', function () {return 'test';});

return $user;
