<?php

$userApp = $app['controllers_factory'];

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Entity\User;
use Entity\ApiKey;

$checkUserPermisson = function (Request $request) use ($app) {
    //check authorization

    $key = $request->headers->get('key');
    $keyDb = $app['db']->getRepository("Entity\ApiKey")->findOneByKey($key);

    if (empty($keyDb)) {
        return new Response("User Unauthorized", 401);
    }
};

$checkUserNotExists = function (Request $request) use ($app) {

    if ($request->getMethod() == "POST") {
        $dataJson = json_decode($request->getContent(), true);
        $result = $app['db']->getRepository("Entity\User")->findUser($dataJson['login']);
        if (!empty($result)) {
            return new Response("User exists", 403);
        }
    }
};

$checkUserAutenticate = function (Request $request) use ($app) {
    if ($request->getMethod() == "POST") {
        $dataJson = json_decode($request->getContent(), true);
        $user = $app['db']->getRepository("Entity\User")->findUser($dataJson['login']);

        if (empty($user)) {
            return new Response("User not exists", 403);
        }

        if (!password_verify($dataJson['password'], $user->getPassword())) {
            return new Response("User Unauthorized", 401);
        }
    }
};
$userApp->get('/', function (Request $request) use($app) {
    $key = $request->headers->get('key');
    $apiKey = $app['db']->getRepository("Entity\ApiKey")->findOneByKey($key);
    $user_id = $apiKey->getUser_id();
    $user = $app['db']->getRepository("Entity\User")->findUserById($user_id);
    
    return $app->json($app['serializer']->serialize($user, 'json'), 200);
});


$userApp->match('/', function (Request $request) use ($app) {

    $dataJson = json_decode($request->getContent(), true);

    $user = new User();
    $user->setLogin($dataJson['login']);
    $user->setPassword($dataJson['password']);

    $app['db']->persist($user);
    $app['db']->flush();

    if ($user->getId() > 0) {
        return new Response("User created", 200);
    }

    return new Response("User invalid", 403);
})->method('POST')->before($checkUserNotExists);

$userApp->post('/authenticate', function (Request $request) use($app) {
    //necessito de luna chave
    $dataJson = json_decode($request->getContent(), true);
    $user = $app['db']->getRepository("Entity\User")->findUser($dataJson['login']);

    $apiKey = new ApiKey();
    $apiKey->setUser_id($user->getId());
    $app['db']->persist($apiKey);
    $app['db']->flush();

    if ($apiKey->getId() > 0) {
        return $app->json(array("key" => $apiKey->getKey()), 201);
    }
    return new Response("No ", 403);
})->before($checkUserAutenticate);


$userApp->put('/', function (Request $request) use ($app) {
    $key = $request->headers->get('key');
    $apiKey = $app['db']->getRepository("Entity\ApiKey")->findOneByKey($key);
    $user_id = $apiKey->getUser_id();
    $user = $app['db']->getRepository("Entity\User")->findUserById($user_id);

    $dataJson = json_decode($request->getContent(), true);

    if (isset($dataJson['login'])) {
        $user->setLogin($dataJson['login']);
    }
    if (isset($dataJson['password'])) {
        $user->setPassword($dataJson['password']);
    }
    $app['db']->merge($user);
    $app['db']->flush();

    if ($user->getId() > 0) {
        return new Response("User updated", 200);
    }
    return new Response("USer invalid", 403);
})->before($checkUserPermisson);


$userApp->delete('/:id', function () {
    return 'test';
});


return $userApp;
