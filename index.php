<?php

require_once __DIR__.'/bootstrap.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$app->before(function (Request $request) {
    // if (false === strpos($request->headers->get('Content-Type'), 'application/json')) {
    //     throw new Exception("Request not in json", 400);
    // }

    $data = json_decode($request->getContent(), true);
    $request->request->replace(is_array($data) ? $data : array());
});

$app->error(function (\Exception $e, Request $request, $code) use ($app) {
    return $app->json($e->getCode() . ' - ' . $e->getMessage());
});

$app->get('/', function () use ($app){
    return $app->json('', 200);
});

$app->get('/{id}', function ($id) use ($app){
    return $app->json($id, 200);
});

$app->put('/', function () use ($app){
    return $app->json('NEW', 200);
});

$app->post('/', function () use ($app){
    return $app->json('UPDATE', 200);
});

$app->delete('/', function () use ($app){
    return $app->json('DELETE', 200);
});

$app->run();
