<?php
date_default_timezone_set('America/Sao_Paulo');
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/JWTWrapper.php';

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Silex\Application;
 
$app = new Silex\Application();
 
$dsn = 'mysql:dbname=contacts;host=127.0.0.1;charset=utf8';
try {
    $dbh = new PDO($dsn, 'list_contacts', 'userTest');
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
} 

$app->post('/auth', function (Request $request) use ($app) {
    $data = json_decode($request->getContent(), true);
 
    if($data['user'] == 'maicon' && $data['pass'] == '123456') {
        $jwt = JWTWrapper::encode([
            'expiration_sec' => 3600,
            'iss' => 'maiconprange',        
            'userdata' => [
                'id' => 1,
                'name' => 'Maicon Eduardo Prange'
            ]
        ]);
 
        return $app->json([
            'login' => 'true',
            'access_token' => $jwt
        ]);
    }
 
    return $app->json([
        'login' => 'false',
        'message' => 'Invalid login',
    ]);
});

$app->before(function(Request $request, Application $app) {
    $route = $request->get('_route');
 
    if($route != 'POST_auth') {
		$authorization = $request->headers->get("Authorization");
        list($jwt) = sscanf($authorization, 'Bearer %s');
 
        if($jwt) {
            try {
                $app['jwt'] = JWTWrapper::decode($jwt);
            } catch(Exception $ex) {
                return new Response('Unauthorized access', 400);
            }
     
        } else {
            return new Response('Token not informed', 400);
        }
    }
});
 
$app->get('/contact', function () use ($app, $dbh) {
    $sth = $dbh->prepare('SELECT id, first_name, last_name, email, phone_number FROM list_contacts');
    $sth->execute();
    $contatos = $sth->fetchAll(PDO::FETCH_ASSOC);
 
    return $app->json($contatos);
});
 
$app->get('/contact/{id}', function ($id) use ($app, $dbh) {
    $sth = $dbh->prepare('SELECT * FROM list_contacts WHERE id=?');
	$sth->execute([$id]);
	$contato = $sth->fetchAll(PDO::FETCH_ASSOC);
    if(empty($contato)) {
        return new Response("Contact id {$id} not found!", 404);
    }
 
    return $app->json($contato);
})->assert('id', '\d+');

$app->post('/contact', function(Request $request) use ($app, $dbh) {
    $data = json_decode($request->getContent(), true);
 
    $sth = $dbh->prepare('INSERT INTO list_contacts (first_name, last_name, email, phone_number) 
            VALUES(:first_name, :last_name, :email, :phone_number)');
     
    $sth->execute($data);
    $id = $dbh->lastInsertId();
 
    $response = new Response('Inserted correctly', 201);
    $response->headers->set('Location', "/list_contacts/$id");
    return $response;
});
 
$app->put('/contact/{id}', function(Request $request, $id) use ($app, $dbh) {
    $data = json_decode($request->getContent(), true);
    $data['id'] = $id;
 
    $sth = $dbh->prepare('UPDATE list_contacts 
            SET first_name=:first_name, last_name=:last_name, email=:email, phone_number:phone_number
            WHERE id=:id');
     
    $sth->execute($data);
    return $app->json($data, 200);
})->assert('id', '\d+');
 
$app->delete('/contact/{id}', function($id) use ($app, $dbh) {
    $sth = $dbh->prepare('DELETE FROM list_contacts WHERE id = ?');
    $sth->execute([ $id ]);
 
    if($sth->rowCount() < 1) {
        return new Response("Contact id {$id} not found!", 404);
    }

    return new Response(null, 204);
})->assert('id', '\d+');  

$app->run();