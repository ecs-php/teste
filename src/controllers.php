<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Doctrine\DBAL\DriverManager;
use Silex\Application;

//Request::setTrustedProxies(array('127.0.0.1'));

$app->before(function (Request $request) use ($app) {
    $data = json_decode($request->getContent(), true);
    $request->request->replace(is_array($data) ? $data : []);

    if ($request->getPathInfo() != '/tokens') {
        // Validate token
        if ($request->get('_token') == '') $app->abort(403);
        $query = 'SELECT COUNT(*) FROM users WHERE token = ?';
        $found = $app['db']->fetchColumn($query, [$request->get('_token')]);
        if (!$found) $app->abort(403);
    }
});

$app->get('/', function (Application $app) {
    return $app->json(['resources' => ['releases']]);
});

$app->put('/tokens', function (Application $app, Request $request) {
    $query = 'SELECT * FROM users WHERE username = ? AND password = MD5(?)';
    $user = $app['db']->fetchAssoc($query, [
        $request->request->get('username'),
        $request->request->get('password')
    ]);

    if (!$user) {
        return $app->json(['message' => 'User not found.'], 404);
    }

    $token = md5(rand());
    $app['db']->update('users', ['token' => $token], ['id' => $user['id']]);

    return $app->json(['token' => $token], 201);
});

$app->get('/releases', function (Application $app, Request $request) {
    $query = 'SELECT * FROM releases';
    $bind = [];

    // Optional search query
    if ($request->get('query')) {
        $query .= ' WHERE MATCH (title, description) AGAINST (? IN BOOLEAN MODE)';
        $bind[] = $request->get('query');
    }

    $releases = $app['db']->fetchAll($query, $bind);

    foreach ($releases as $key => $release) {
        $releases[$key]['tags'] = json_decode($release['tags'], true);
    }
    
    return $app->json(['releases' => $releases]);
});

$app->put('/releases', function (Application $app, Request $request) {
    if ($request->headers->get('Content-Type') != 'application/json') {
        $app->abort(400);
    }

    $release = [];

    if (empty($request->request->get('link'))) {
        $app->abort(400, 'Link is required.');
    }

    $release['link'] = $request->request->get('link');

    if ($request->request->get('description')) {
        $release['description'] = $request->request->get('description');
    }

    if ($request->request->get('tags')) {
        $release['tags'] = json_encode($request->request->get('tags'));
    }

    if ($request->request->get('title')) {
        $release['title'] = $request->request->get('title');
    }

    try {
        $app['db']->insert('releases', $release);
        $id = $app['db']->lastInsertId();
    } catch (\Exception $e) {
        throw new \Exception('Error while inserting release.');
    }

    return $app->json(['id' => $id], 201);
});

$app->post('/releases/{id}', function (Application $app, Request $request, $id) {
    $query = 'SELECT * FROM releases WHERE id = ?';
    $release = $app['db']->fetchAssoc($query, [(int) $id]);

    if (!$release) {
        return $app->json(['message' => 'Release not found.'], 404);
    }

    if ($request->request->get('description')) {
        $release['description'] = $request->request->get('description');
    }

    if ($request->request->get('link')) {
        $release['link'] = $request->request->get('link');
    }

    if ($request->request->get('tags')) {
        $release['tags'] = json_encode($request->request->get('tags'));
    }

    if ($request->request->get('title')) {
        $release['title'] = $request->request->get('title');
    }

    try {
        $app['db']->update('releases', $release, ['id' => $release['id']]);
    } catch (\Exception $e) {
        throw new \Exception('Error while updating release.');
    }

    return new Response(null, 200);
});

$app->delete('/releases/{id}', function (Application $app, $id) {
    $query = 'SELECT * FROM releases WHERE id = ?';
    $release = $app['db']->fetchAssoc($query, [(int) $id]);

    if (!$release) {
        return $app->json(['message' => 'Release not found.'], 404);
    }

    $app->delete('releases', ['id' => $release['id']]);

    return new Response(null, 200);
});

$app->get('/releases/{id}', function (Application $app, $id) {
    $query = 'SELECT * FROM releases WHERE id = ?';
    $release = $app['db']->fetchAssoc($query, [(int) $id]);

    if (!$release) {
        return $app->json(['message' => 'Release not found.'], 404);
    }

    $release['tags'] = json_decode($release['tags'], true);

    return $app->json($release);
});

$app->error(function (\Exception $e, Request $request, $code) use ($app) {
    if ($e->getMessage() != '') {
        return $app->json(['message' => $e->getMessage()], $code);
    } else {
        return new Response(null, $code);
    }
});
