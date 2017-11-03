<?php

use Psr7Middlewares\Middleware\TrailingSlash;

$app->add(new TrailingSlash(false));

$app->add(new \Slim\Middleware\HttpBasicAuthentication([

    "users" => [
        "root" => "toor"
    ],

    "path" => ["/auth"],

    //"passthrough" => ["/auth/liberada", "/admin/ping"],
]));


$app->add(new \Slim\Middleware\JwtAuthentication([
    "regexp" => "/(.*)/",
    "header" => "X-Token",
    "path" => "/",
    "passthrough" => ['/','/auth', '/draw-date', '/winner'],
    "logger" => $logger,
    "realm" => "Protected",
    "secret" => $container['secretkey'],
    "secure" => false,
    "callback" => function ($request, $response, $arguments) use ($container) {
        $container["jwt"] = $arguments["decoded"];
    },
    "error" => function ($request, $response, $arguments) {
    $data["status"] = "error";
    $data["message"] = $arguments["message"];
    return $response
        ->withHeader("Content-Type", "application/json")
        ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
}

]));