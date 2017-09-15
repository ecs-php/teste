<?php 
define('APP_ROOT', dirname(__DIR__));
chdir(APP_ROOT);

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Test\User\User;

require 'vendor/autoload.php';

$app = new Application();

$app['debug'] = true;

$app['entity'] = function(Application $app) {
	 $pdo = new \PDO('mysql:host=localhost;dbname=test', 'root', 'root');
	 return new Test\Entity\Entity($pdo);
};

$app['timezone'] = 'America/Sao_Paulo';
$app['currentDateTime'] = function(Application $app) {
	date_default_timezone_set($app['timezone']);
	return date('Y-m-d H:i', strtotime("now"));
  };

$app->get('/', function(Application $app){
	return $app->redirect('/api/v1');
});

$app->get('/api/v1', function(Request $request) use ($app) {

	return 'API Working';

});

$app->get('/api/v1/users', function(Application $app){
	$user  = new User($app['entity']);
	$users = $user->getEntity()->getAll();

	return $app->json($users); 
});

$app->get('/api/v1/users/{id}', function(Application $app, $id){

	$user = new User($app['entity']);
	$user = $user->getEntity()->where(array('id' => $id));

	return $app->json($user);
})
->convert('id', function($id){ return (int) $id; });

$app->post('/api/v1/users', function(Application $app, Request $request){
	$data = json_decode($request->getContent(), true);
	
	$user = array(
		'name'  => (string) $data['name'],
		'email' => (string) $data['email'],
		'password' => (string) $data['password'],
		'created' => $app['currentDateTime']
	);
	
	$save = new User($app['entity']);
	$save = $save->getEntity()->save($user);
    
    $return = array('status' => true);
	
	if(!$save) $return = array('status' => false);

	return $app->json($return);

});

$app->put('/api/v1/users/{id}', function(Application $app, Request $request, $id){
	
	$data = json_decode($request->getContent(), true);
	
	$user = array(
		'name'  => (string) $data['name'],
		'email' => (string) $data['email'],
		'password' => (string) $data['password'],
		'updated' => $app['currentDateTime']
	);

	$update = new User($app['entity']);
	$update = $update->getEntity()->update($id, $user);


    $return = array('status' => true);
	
	if(!$update) $return = array('status' => false);

	return $app->json($return);

});

$app->delete('/api/v1/users/{id}', function(Application $app, $id){

	$user = new User($app['entity']);
	$userDeleted = $user->getEntity()->delete($id);


    $return = array('status' => true);
	
	if(!$userDeleted) $return = array('status' => false);

	return $app->json($return);
});

$app->run();