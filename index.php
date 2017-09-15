<?php

require 'vendor/autoload.php';
require 'connection.php';
$app = new Silex\Application();

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

$app->before(function ($request, $app) use ($dbh) {
    $auth = $request->headers->get("Authorization");
    $apikey = substr($auth, strpos($auth, ' '));
    $apikey = trim($apikey);

    $sth = $dbh->prepare('SELECT * FROM users where apikey=?');
    $sth->execute([$apikey]);
    $user = $sth->fetchAll(PDO::FETCH_ASSOC);

    if (empty($user)) {
        return new Response("Unauthorized!", 401);
    } else {
        $check = true;
        $request->attributes->set('userid', $check);
    }

});

$app->get('/tasks', function () use ($app, $dbh) {
    $sth = $dbh->prepare('SELECT * FROM tasks');
    $sth->execute();
    $messages = $sth->fetchAll(PDO::FETCH_ASSOC);

    return $app->json($messages);
});

$app->get('/tasks/{id}', function ($id) use ($app, $dbh) {
    $sth = $dbh->prepare('SELECT * FROM tasks WHERE id=?');
    $sth->execute([$id]);

    $message = $sth->fetchAll(PDO::FETCH_ASSOC);
    if (empty($message)) {
        return new Response("Task {$id} not found!", 404);
    }

    return $app->json($message);
})->assert('id', '\d+');

$app->post('/tasks', function (Request $request) use ($app, $dbh) {
    $data = json_decode($request->getContent(), true);
    $data['created_at'] = date('Y-m-d H:i:s', time());
    $data['updated_at'] = date('Y-m-d H:i:s', time());

    $sth = $dbh->prepare('INSERT INTO tasks (title, description, estimation_time,  priority, created_at, updated_at)
            VALUES(:title, :description, :estimation_time, :priority, :created_at,:updated_at)');

    $sth->execute($data);

    $response = new Response('Created successfully', 201);
    return $response;
});

$app->put('/tasks/{id}', function (Request $request, $id) use ($app, $dbh) {
    $data = json_decode($request->getContent(), true);
    $data['updated_at'] = date('Y-m-d H:i:s', time());
    $data['id'] = $id;

    $sth = $dbh->prepare('UPDATE tasks 
            SET title=:title, description=:description, development_time=:development_time, updated_at=:updated_at
            WHERE id=:id');

    $sth->execute($data);
    return $app->json($data, 200);
})->assert('id', '\d+');

$app->delete('/tasks/{id}', function ($id) use ($app, $dbh) {
    $sth = $dbh->prepare('DELETE FROM tasks WHERE id = ?');
    $sth->execute([$id]);

    if ($sth->rowCount() < 1) {
        return new Response("Task {$id} not found!", 404);
    }

    $response = new Response('Deleted successfully', 204);

    return $response;
})->assert('id', '\d+');


$app->run();