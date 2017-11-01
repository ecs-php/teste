<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;

$app = new Silex\Application();

$app['debug'] = true;

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver' => 'pdo_mysql',
        'host' => 'localhost',
        'dbname' => 'serasaphp',
        'user' => 'root',
        'password' => 'root'
    ),
));

$app->get('/', function() use ($app) {
    $subRequest = Request::create('/admin/penguins', 'GET');
    return $app->handle($subRequest, HttpKernelInterface::SUB_REQUEST);
});

// Autenticacao
$app->post('/auth', function (Request $request) use ($app) {
    $dados = json_decode($request->getContent(), true);


    $encoded = crypt($dados['password'], 16);

    $db = $app['db'];
    $sql = "SELECT * FROM user WHERE username = ? AND password = ?;";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(1, $dados['username']);
    $stmt->bindValue(2, $encoded);
    $stmt->execute();
    $user = $stmt->fetch();

    if(!empty($user)) {
        // autenticacao valida, gerar token
        $jwt = JWTWrapper::encode([
            'expiration_sec' => 3600,
            'userdata' => [
                'id' => $user['id'],
                'name' => $user['name']
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

// verificar autenticacao
$app->before(function(Request $request, $app) {
    $route = $request->get('_route');

    if($route != 'POST_auth' && $route != 'GET_create_table') {
        $authorization = $request->headers->get("Authorization");
        list($jwt) = sscanf($authorization, 'Bearer %s');

        if($jwt) {
            try {
                $app['jwt'] = JWTWrapper::decode($jwt);
            } catch(Exception $ex) {
                return $app->json(["status" => "error", "message" => "Invalid token !"]);
            }
        } else {
            return $app->json(["status" => "error", "message" => "Token was not informed !"]);
        }
    }
});

$app->get('/create-table', function (Silex\Application $app) {
    $file = fopen(__DIR__ . '/../data/schema.sql', 'r');
    while ($line = fread($file, 4096)) {
        $app['db']->executeQuery($line);
    }
    fclose($file);
    return $app->json(["status" => "success", "message" => "Tabelas criadas"]);
});

$app->mount('/admin', function($admin) use($app){
    $penguins = include __DIR__ . '/controllers/penguins.php';
    $admin->mount('/penguins', $penguins);
});

$app->error(function(\Exception $e, Request $request, $code) use($app){
    switch ($code){
        case 404:
            return $e->getMessage();
    }
});

$app->run();

