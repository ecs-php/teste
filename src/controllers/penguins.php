<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

$penguin = $app['controllers_factory'];

$penguin->get('/', function () use ($app) {
    /** @var \Doctrine\DBAL\Connection $db */
    $db = $app['db'];
    $sql = "SELECT * FROM penguin;";
    $penguins = $db->fetchAll($sql);
    return new JsonResponse(["status" => "success", "result" => $penguins]);
});

$penguin->post('/create', function (Request $request) use ($app) {
    /** @var \Doctrine\DBAL\Connection $db */
    $db = $app['db'];
    $data = json_decode($request->getContent(), true);
    $db->insert('penguin', [
        'name' => $data['name'],
        'age' => $data['age'],
        'species' => $data['species'],
        'gender' => $data['gender']
    ]);
    return new JsonResponse(["status" => "success", "message" => "the penguin has been created !"]);
});


$penguin->get('/find/{id}', function ($id) use ($app) {
    /** @var \Doctrine\DBAL\Connection $db */
    $db = $app['db'];
    $sql = "SELECT * FROM penguin WHERE id = ?;";
    $penguin = $db->fetchAssoc($sql, [$id]);
    if(!$penguin){
        return new JsonResponse(["error" => "Penguin not found !"]);
    }
    return new JsonResponse(["status" => "success", "result" => $penguin]);
});

$penguin->put('/edit/{id}', function (Request $request, $id) use ($app) {
    /** @var \Doctrine\DBAL\Connection $db */
    $db = $app['db'];
    $sql = "SELECT * FROM penguin WHERE id = ?;";
    $penguin = $db->fetchAssoc($sql, [$id]);
    if(!$penguin){
        return new JsonResponse(["error" => "Penguin not found !"]);
    }
    $data = $request->request->all();
    $db->update('penguin', $data, ['id' => $id]);
    return new JsonResponse(["status" => "success", "message" => "the penguin has been updated !"]);
});

$penguin->delete('/delete/{id}', function ($id) use ($app) {
    /** @var \Doctrine\DBAL\Connection $db */
    $db = $app['db'];
    $sql = "SELECT * FROM penguin WHERE id = ?;";
    $penguin = $db->fetchAssoc($sql, [$id]);
    if(!$penguin){
        return new JsonResponse(["error" => "Penguin not found !"]);
    }
    $db->delete('penguin', ['id' => $id]);
    return new JsonResponse(["status" => "success", "message" => "the penguin has been deleted !"]);
});

return $penguin;