<?php

$productApp = $app['controllers_factory'];

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Entity\Product;

$checkProductExist = function (Request $request) use ($app) {

    $id = (int) $request->get("id");

    $product = $app['db']->getRepository("Entity\Product")->findById($id);


    if (empty($product)) {
        return new Response("Product not exists", 404);
    }
};

$productApp->before(function (Request $request) use ($app) {
    //check authorization
    $key = $request->headers->get('key');
    $keyDb = $app['db']->getRepository("Entity\ApiKey")->findOneByKey($key);

    if (empty($keyDb)) {
        return new Response("User Unauthorized", 401);
    }
    $app['db']->merge($keyDb);
    $app['db']->flush();
});

$productApp->match('/', function (Request $request) use($app) {

    $dataJson = json_decode($request->getContent(), true);
    $product = new Product();

    $product->setName($dataJson['name']);
    $product->setPrice($dataJson['price']);
    $product->setDiscount($dataJson['discount']);
    $product->setDescription($dataJson['description']);
    $product->setCategory($dataJson['category']);

    $app['db']->persist($product);
    $app['db']->flush();

    if ($product->getId() > 0) {
        return new Response("Product created", 201);
    }
    return new Response("Product invalid", 404);
})->method('POST')->before(function (Request $request) use ($app) {

    $dataJson = json_decode($request->getContent(), true);
    $product = $app['db']->getRepository("Entity\Product")->findProductByName($dataJson['name']);

    if (!empty($product)) {
        return new Response("Product exists", 304);
    }
});


$productApp->get('/', function (Request $request) use ($app) {

    $products = $app['db']->getRepository("Entity\Product")->findAllProductsToArray();
    return $app->json($app['serializer']->normalize($products, 'json'), 200);
});

$productApp->get('/{id}', function ($id) use ($app) {

    $products = $app['db']->getRepository("Entity\Product")->findById($id);
    return $app->json($app['serializer']->normalize($products, 'json'), 200);
})->assert('id', '\d+')->before($checkProductExist);


$productApp->put('/{id}', function (Request $request, $id) use($app) {


    $dataJson = json_decode($request->getContent(), true);
    $product = $app['db']->getRepository("Entity\Product")->findById($id);

    if (isset($dataJson['name'])) {
        $product->setName($dataJson['name']);
    }
    if (isset($dataJson['description'])) {
        $product->setDescription($dataJson['description']);
    }
    if (isset($dataJson['discount'])) {
        $product->setDiscount($dataJson['discount']);
    }
    if (isset($dataJson['price'])) {
        $product->setPrice($dataJson['price']);
    }
    if (isset($dataJson['category'])) {
        $product->setCategory($dataJson['category']);
    }

    $app['db']->merge($product);
    $app['db']->flush();

    if ($product->getId() > 0) {
        return new Response("Product updated", 200);
    }
    return new Response("Product invalid", 403);
})->assert('id', '\d+')->before($checkProductExist);

$productApp->delete('/{id}', function (Request $request, $id) use($app) {

    $product = $app['db']->getRepository("Entity\Product")->findById($id);
    $app['db']->remove($product);
    $app['db']->flush();
    ;
    return new Response("Product removed", 200);
})->assert('id', '\d+')->before($checkProductExist);


return $productApp;
