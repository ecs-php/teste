<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

//Request::setTrustedProxies(array('127.0.0.1'));

$app->get('/user', function () use ($app) {
    $users = $app['db']->fetchAll('SELECT * FROM users');
    return $app->json($users);
});
$app->get('/user/{id}', function ($id) use ($app) {
    $users = $app['db']->fetchAll('SELECT * FROM users WHERE id = '.$id);
    return $app->json($users);
});

$app->put('/user', function (Request $request) use ($app) {
    $dados = json_decode($request->getContent(), true);

    $app['db']->insert('users', array(
        'name' => $dados['name'],
        'email' => $dados['email'],
        'date_birth' => $dados['date_birth'],
        'address' => $dados['address'],
        'created_at' => date("Y-m-d H:i:s"),
        'updated_at' => date("Y-m-d H:i:s"),
    ));
    $user = $app['db']->fetchAll('SELECT * FROM users WHERE id = '.$app['db']->lastInsertId());
    return $app->json($user);
});

$app->put('/user/{id}', function (Request $request, $id) use ($app) {
    $dados = json_decode($request->getContent(), true);
    $app['db']->update('users', $dados, array('id' => $id));

    return $app->json($app['db']->fetchAll('SELECT * FROM users WHERE id = '.$id));
});

$app->delete('/user/{id}', function ($id) use ($app) {
    $user = $app['db']->fetchAll('SELECT * FROM users WHERE id = '.$id);
    $app['db']->delete('users', array('id' => $id));
    return $app->json($user);
});