<?php

require_once __DIR__ . '/vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\ValidationData;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Builder;

date_default_timezone_set('America/Sao_Paulo');

$app = new Silex\Application();

$app['debug'] = true;
$app['connection'] = function(){
    return new PDO("mysql:host=localhost;dbname=teste;charset=utf8", 'root', '');
};

$app['security'] = [
    'allowedURIs' => ['/testeESC/generate-token'], 
    'jwt'         => ['secret' => 'AS109238ALSKFD']
];

$app->before(function (Request $request, $app) {
    $uri = $request->getRequestUri();
    $allowedURIs = $app['security']['allowedURIs'];


    if (in_array($uri, $allowedURIs)) {
        return;
    }
    if (!$request->headers->has('authorizationkey')) {
        return new Response('', 401, ['WWW-Authenticate' => 'Bearer']);
    }

    /* @var string[] $tokens */
    $tokens = array_filter(explode(' ', $request->headers->get('authorizationkey'), 2));

    if (count($tokens) !== 2) {
        return new Response('', 401, ['WWW-Authenticate' => 'Bearer']);
    }

    if ('Bearer' !== ucfirst($tokens[0])) {
        return new Response('', 401, ['WWW-Authenticate' => 'Bearer']);
    }

    /* @var string $tokenString */
    $tokenString = $tokens[1];
    $tokenParser = new Parser();

    try {
        $token = $tokenParser->parse($tokenString);
    } catch (\InvalidArgumentException $e) {
        return new Response('', 403);
    }

    $tokenSigner = new Sha256();
    $jwtKey = $app['security']['jwt']['secret'];
    $didVerifyAndValidate = (
        $token->validate(new ValidationData()) &&
        $token->verify($tokenSigner, $jwtKey)
    );

    if (!$didVerifyAndValidate) {
        return new Response('', 401);
    }
});

$app->post('/generate-token', function () use ($app) {
    $data = json_decode(file_get_contents('php://input'), true);
    $db = $app['connection'];
    
    $sql = "SELECT * FROM users where username='".$data['username']."'";
    $stmt = $db->query($sql);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        return new Response(400);
    }
    
    if (! password_verify($data['password'], $user['password'])) {
        return new Response(400);
    }
    
    $builder = new Builder();

    $builder->setIssuedAt(time());
    $builder->setNotBefore(time());
    $builder->set('userId', $user['id']);

    $tokenSigner = new Sha256();
    $jwtKey = $app['security']['jwt']['secret'];

    $builder->sign($tokenSigner, $jwtKey);

    return (string) $builder->getToken();
 });

$app->get('/users', function(Request $request) use ($app){

	$sql = 'SELECT * FROM users';

	try {
        /* @var $db PDO */
        $db = $app['connection'];
        $stmt = $db->query($sql);
        $return = $stmt->fetchAll(PDO::FETCH_OBJ);

        return new JsonResponse($return);
        
    } catch(\PDOException $e) {
        return new Response(400, ['message' => $e->getMessage()]);
    };

});

$app->get('users/{id}', function($id) use ($app){

	$sql = "SELECT * FROM users where id='".$id."'";

    try {
        /* @var $db PDO */
        $db = $app['connection'];
        $stmt = $db->query($sql);
        $return = $stmt->fetch(PDO::FETCH_OBJ);
        
        return new JsonResponse($return);

    } catch(\PDOException $e) {
        return new Response(400, ['message' => $e->getMessage()]);    
    }

});

$app->post('/users', function(Request $request) use ($app){
	$data = json_decode(file_get_contents('php://input'), true);
    $hash = password_hash($data['password'], PASSWORD_DEFAULT);
	$sql = 'INSERT INTO users(name, username, password, address)VALUES(?, ?, ?, ?)';

	try {
        /* @var $db PDO */
        $db = $app['connection'];
        $stmt = $db->prepare($sql);
        $paramOrder = 1;

        $stmt->bindParam($paramOrder++, $data['name']);
        $stmt->bindParam($paramOrder++, $data['username']);
        $stmt->bindParam($paramOrder++, $hash);
        $stmt->bindParam($paramOrder++, $data['address']);

        $stmt->execute();
        
        return new Response();

    } catch(\PDOException $e) {
        return new Response(400, ['message' => $e->getMessage()]);
    }

});

$app->put('/users', function(Request $request) use ($app){
    
	$data = json_decode(file_get_contents('php://input'), true);
    $hash = password_hash($data['password'], PASSWORD_DEFAULT);
    $sql = "UPDATE users SET name= ?, username = ?, password = ?, address = ? WHERE id = ?";

    try {
        /* @var $db PDO */
        $db = $app['connection'];
        $stmt = $db->prepare($sql);
        $paramOrder = 1;

        $stmt->bindParam($paramOrder++, $data['name']);
        $stmt->bindParam($paramOrder++, $data['username']);
        $stmt->bindParam($paramOrder++, $hash);
        $stmt->bindParam($paramOrder++, $data['address']);
        $stmt->bindParam($paramOrder++, $data['id']);

        $stmt->execute();

        return new Response();

    } catch(\PDOException $e) {
        return new Response(400, ['message' => $e->getMessage()]);
    }
});

$app->delete('/users/{id}', function($id) use ($app){
    $sql = 'DELETE FROM users WHERE id = ?';

    try {
        /* @var $db PDO */
        $db = $app['connection'];
        $stmt = $db->prepare($sql);
        $paramOrder = 1;

        $stmt->bindParam($paramOrder++, $id);

        $stmt->execute();

        return new Response();

    } catch (\PDOException $e) {
        return new Response(400, ['message' => $e->getMessage()]);;
    }
});

$app->run();