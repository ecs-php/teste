<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Silex\Application;
use Silex\Provider\DoctrineServiceProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Serasa\JWTWrapper;

$app = new Application();
$app['debug'] = true;

$app->register(new DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver' => 'pdo_mysql',
        'host' => 'localhost',
        'dbname' => 'serasa_test',
        'user' => 'serasa',
        'password' => 'serasa'
    ),
));

$app->before(function(Request $request, Application $app) {
    $route = $request->get('_route');
    if($route != 'POST_books_api_auth') {
        $authorization = $request->headers->get("Authorization");
        list($jwt) = sscanf($authorization, '%s');
        if($jwt) {
            try {
                $app['jwt'] = JWTWrapper::decode($jwt);
            } catch(Exception $ex) {
                return new Response('Access denied', 401);
            }
        } else {
            return new Response('Token not informed', 401);
        }
    }
});

$books = $app['controllers_factory'];
$app->mount('/books/api', $books);

$books->post('/auth', function (Application $app, Request $request){
    $data = json_decode($request->getContent(), true);
    //dados de usuario hardcode para exemplo
    if(array_key_exists('email', $data) && array_key_exists('password', $data)){
        if($data['email'] == 'macedodosanjosmateus@gmail.com' && $data['password'] == '123Mudar') {
            $jwt = JWTWrapper::encode([
                'expiration' => 3600,
                'domain' => 'macedodosanjosmateus@gmail.com',
                'userData' => [
                    'id' => 1,
                    'name' => 'Mateus Macedo Dos Anjos'
                ]
            ]);
            return $app->json([
                'login' => 'true',
                'accessToken' => $jwt
            ]);
        }
        return $app->json([
            'login' => 'false',
            'message' => 'Login Inválido',
        ]);
    }
    return new Response('Invalid request', 400);
});

$books->post('/create', function (Application $app, Request $request){
    if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
        if($data = json_decode($request->getContent(), true)){
            if(array_key_exists('id', $data)) unset($data['id']);
            $dateTimeNow = new \DateTime();
            $data['created'] = $dateTimeNow->format('Y-m-d H:i:s');
            $data['modified'] = $dateTimeNow->format('Y-m-d H:i:s');
            $app['db']->insert('books', $data);
            $id = $app['db']->lastInsertId();
            return new Response("$id", 201);
        }
    }
    return new Response('Invalid request', 400);
});

$books->get('/retrieve', function (Application $app, Request $request){
    if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
        $sql = "SELECT * FROM books;";
        $books = $app['db']->fetchAll($sql);
        return $app->json($books);
    }
    return new Response('Invalid request', 400);
});

$books->get('/retrieve/{id}', function(Application $app, Request $request, $id){
    if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
        $sql = "SELECT id, title, author, publishing, isbn, created, modified FROM books WHERE id = ?;";
        $book = $app['db']->fetchAssoc($sql, [$id]);
        if(!$book) return new Response('Not Found', 404);
        return $app->json($book);
    }
    return new Response('Invalid request', 400);
})->assert('id', '\d+');

$books->put('/update/{id}',function(Application $app, Request $request, $id){
    if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
        if($data = json_decode($request->getContent(), true)){
            if(array_key_exists('id', $data)) unset($data['id']);
            if(array_key_exists('created', $data)) unset($data['created']);
            $sql = "SELECT id FROM books WHERE id = ?;";
            $book = $app['db']->fetchAssoc($sql, [$id]);
            if(!$book) return new Response('Not Found', 404);
            $dateTimeNow = new \DateTime();
            $data['modified'] = $dateTimeNow->format('Y-m-d H:i:s');
            $app['db']->update('books', $data, ['id' => $id]);
            return new Response("Successfully updated", 200);
        }
    }
    return new Response('Invalid request', 400);
})->assert('id', '\d+');

$books->get('/delete/{id}', function(Application $app,Request $request, $id){
    if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
        $sql = "SELECT id FROM books WHERE id = ?;";
        $book = $app['db']->fetchAssoc($sql, [$id]);
        if(!$book) return new Response('Not Found', 404);
        $app['db']->delete('books',['id' => $id]);
        return new Response('Success', 200);
    };
    return new Response('Invalid request', 400);
})->assert('id', '\d+');

$app->run();