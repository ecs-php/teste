<?php

$product = $app['controllers_factory'];

use Symfony\Component\Console\Application;
use Symfony\Component\HttpFoundation\Request;

$product->before(function (Request $request, Application $app) { 
    
});
$product->get('/', function () { return 'all'; });
$product->get('/:id', function () { return 'especific';});
$product->post('/', function () { return 'all'; });
$product->put('/:id', function () { return 'especific';});
$product->delete('/:id', function () { return 'especific';});

return $product;
