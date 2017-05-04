<?php

$userApp = $app['controllers_factory'];

use Symfony\Component\Console\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Entity\User;
use Entity\ApiKey;

$beforeUser = function (Request $request) use ($app) {

    switch ($request->getMethod()) {
        case "POST":
            $dataJson = json_decode($request->getContent(), true);
            $result = $app['db']->getRepository("Entity\User")->findUser($dataJson['login']);
            if (!empty($result)) {
                return new Response("User exists", 403);
            }

            break;
        case "PUT":

            break;
        case "DELETE":

            break;
    }

//    dump($request->getMethod());
//    dump($request->getContent());
//    exit;
};

$beforeAutenticate = function (Request $request) use ($app) {
    switch ($request->getMethod()) {
        case "POST":
            $dataJson = json_decode($request->getContent(), true);
            $user = $app['db']->getRepository("Entity\User")->findUser($dataJson['login']);

            if (empty($user)) {
                return new Response("User not exists", 403);
            }

            if (!password_verify($dataJson['password'], $user->getPassword())) {
                return new Response("User Unauthorized", 401);
            }


            break;
    }
};

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
})->method('POST')->before($beforeUser);

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
})->before($beforeAutenticate);





$userApp->put('/:id', function () {
    return 'test';
});
$userApp->delete('/:id', function () {
    return 'test';
});

return $userApp;
