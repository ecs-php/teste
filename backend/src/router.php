<?php

use Classes\Authentication;
use Classes\UserRepository;
use Classes\ProductRepository;
use Symfony\Component\HttpFoundation\Request;

$app->before(function(Request $request, $app) {

    UserRepository::get()->init($request, $app);
    Authentication ::get() ->init($request, $app);
    ProductRepository::get()->init($request, $app);
    if($request->get('_route') != 'login'){
        Authentication::get()->authenticate();
    }

});


$app->post('/login', function(Request $request) use ($app) {
    header('Content-Type: application/json');
    return Authentication::get()->login();
})->bind('login');

$app->get('/product', function(Request $request) use ($app) {
    header('Content-Type: application/json');
    return json_encode(ProductRepository::get()->listAll());
});

$app->get('/product/{product_id}', function($product_id) use ($app) {
    header('Content-Type: application/json');
    return json_encode(ProductRepository::get()->getOne($product_id));
});
$app->post('/product', function(Request $request) use ($app) {
    $product = json_decode($request->getContent(),true);
    header('Content-Type: application/json');
    return json_encode(ProductRepository::get()->addOne($product));
});
$app->put('/product/{product_id}', function(Request $request, $product_id) use ($app) {
    $product = json_decode($request->getContent(),true);
    header('Content-Type: application/json');
    return json_encode(ProductRepository::get()->updateOne($product_id,$product));
});

$app->delete('/product/{product_id}', function(Request $request, $product_id) use ($app) {
    return ProductRepository::get()->removeOne($product_id);
});