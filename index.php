<?php


use App\Models\DrawDate;
use App\Models\Winner;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ParameterBag;
use Firebase\JWT\JWT;


require 'bootstrap.php';


$key = 'root';
$token = array(
    "admin" => 'lucasSilva',
    "corporation" => 'serasa'
);

$jwt = JWT::encode($token, $key);

$app['token'] = $jwt;

$app['debug'] = true;


$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/views',
));



$app->before(function (Request $request) use ($app){



    if(strpos($request->getRequestUri(), 'user')){
        if (
            ($request->headers->get('Content-Type') != 'application/json')
        ) {
            throw new InvalidArgumentException("Content-type invalid", 400);
        }
        $token = $request->headers->get("Authorization");
        if ($token != $app['token']) {
            throw new Exception("Access denied, token is required for access.", 401);
        }

        $data = json_decode($request->getContent(), true);
        $request->request->replace(is_array($data) ? $data : array());
    }

});

$app->error(function (Exception $e) use ($app) {
    return $app->json($e->getMessage(), $e->getCode());
});


$app->get('/', function () use ($app) {
    return $app['twig']->render('index.html.twig');
});


$app->get('/auth', function () use ($app) {


    return $app->json(
        [
            'Token-jwt' => $app['token'] ,
        ], 200, ['Content-Type' => 'application/json']
    );

});


$userController = $app['controllers_factory'];

$userController->get('/', 'App\Controllers\UserController::index');
$userController->get('/{id}', 'App\Controllers\UserController::find');
$userController->post('/','App\Controllers\UserController::create');
$userController->put('/{id}', 'App\Controllers\UserController::update');
$userController->delete('/{id}', 'App\Controllers\UserController::delete');



$app->mount('/user', $userController)->error(function(Exception $e, $code) {
    return $code;
});


$app->get('/draw-date', function (Request $request) use ($app) {
    $dates = DrawDate::all();

    return $app->json(
        [
            'msg' => "Success when list dates all",
            'data' => $dates
        ], 200, ['Content-Type' => 'application/json']
    );

});

$app->get('/winner', function (Request $request) use ($app) {

    $winners = Winner::selectRaw("
        users.city,
        users.code,
        users.name,
        users.name,
        DATE_FORMAT(draw_dates.date, '%d/%m') as date")
        ->join('users', 'users.id', 'winners.user_id')
        ->join('draw_dates', 'draw_dates.id', 'winners.draw_date_id')
        ->get();

    return $app->json(
        [
            'msg' => "Success when list winners",
            'data' => $winners
        ], 200, ['Content-Type' => 'application/json']
    );

});

$app->run();