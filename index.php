<?php
require_once 'vendor/autoload.php';
require_once 'Planet.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ParameterBag;

$app = new Silex\Application();

// Verificar se o Content-Type é JSON e caso for, definir a classe Request com os valores do JSON
$app->before(function(Request $request) {
    if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
        $data = json_decode($request->getContent(), true);
        $request->request->replace(is_array($data) ? $data : array());
    }
});

// Solução simplificada para o login por questão de tempo
$user = array('username' => 'ROOT', 'password' => 'MASTER');
$app->before(function(Request $request) use ($app) {
	$access_token = $request->query->get('access_token') ?  $request->query->get('access_token') :$request->headers->get('X-Access-Token');
	error_log($access_token);
	if($access_token && stripos($request->getPathInfo(), 'login')===false){
		if(md5($user['password'] . date('YmdH')) != $access_token){
			return $app->json(array('success' => false, 'message' => 'Invalid Token'), 403);
		}
	} else {
		return $app->json(array('success' => false, 'message' => 'You must provide a valid Access Token'), 403);
	}
});

// Registrar informações referentes ao banco de dados
$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array (
	    'driver'    => 'pdo_mysql',
	    'host'      => 'localhost',
	    'dbname'    => 'test_db',
	    'user'      => 'root',
	    'password'  => '',
	    'charset'   => 'utf8mb4',
    ),
));

// Buscar todos
$app->get('/planets', function() use($app) {
	return $app->json(Planet::getAll(), 200);
});

// Adicionar novo
$app->post('/planets', function(Request $request) use ($app) {
	$inserted = Planet::insert($request);
	return $app->json($inserted, 200);
});

// Atualizar existente
$app->put('/planets/{id}', function(Request $request, $id) use ($app) {
	error_log(var_export($request, true));
	$inserted = Planet::update($request, $id);
	return $app->json(array('success' => $inserted), 200);
});

// Buscar existente
$app->get('/planets/{id}', function(Request $request, $id) use($app) {
	return $app->json(Planet::get($id), 200);
});

// Deletar existente
$app->delete('/planets/{id}', function($id) use($app) {
	$planet = Planet::get($id);
	if($planet){
		$result = Planet::delete($id);
		return $app->json(array('success' => $result), 200);
	} else{
		return $app->json(array('success' => false, 'message' => 'Product does not exist'), 404);
	}
});

$app->post('/login', function(Request $request) use ($app) {
	if($request->get('username') == $user['username'] && $request->get('password') == $request->get('password')){
		return $app->json(array('success' => true, 'token' => md5($user['password'] . date('YmdH'))), 200);
	} else {
		return $app->json(array('success' => false), 401);
	}
});

$app->run();
?>