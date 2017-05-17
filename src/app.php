<?php

use Silex\Application;
use Silex\Provider\DoctrineServiceProvider;
use Dflydev\Provider\DoctrineOrm\DoctrineOrmServiceProvider;
use Silex\Provider\SerializerServiceProvider;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use App\Service\BookService;
use App\Converter\BookConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Exception\AppException;
use App\Middleware\AcceptValidator;
use App\Middleware\ContentTypeValidator;
use App\Middleware\Authentication;

$app = new Application();

$app->register(new SerializerServiceProvider());
$app->register(new DoctrineServiceProvider());
$app->register(new DoctrineOrmServiceProvider(), array(
    'orm.proxies_dir' => __DIR__ . '/../var/doctrine/proxies',
    'orm.strategy.naming' => new Doctrine\ORM\Mapping\UnderscoreNamingStrategy(),
    'orm.em.options' => array(
        'mappings' => array(
            array(
                'use_simple_annotation_reader' => false,
                'type' => 'annotation',
                'namespace' => 'App\Entity',
                'path' => __DIR__ . '/App/Entity',
            ),
        ),
    ),
));

$app->extend('serializer.normalizers', function($normalizers) {
    array_unshift($normalizers, new DateTimeNormalizer());
    return $normalizers;
});

$app['app.service.book'] = function ($app) {
    return new BookService($app['orm.em']);
};

$app['app.converter.book'] = function ($app) {
    return new BookConverter($app['orm.em']);
};

$app['app.validator.accept'] = function () {
    return new AcceptValidator();
};

$app['app.validator.contentType'] = function () {
    return new ContentTypeValidator();
};

$app['app.authentication'] = function () {
    return new Authentication();
};

$app->error(function(AppException $e, Request $request, $code) {
    return JsonResponse::fromJsonString($e->getMessage(), $e->getCode());
});

$app->error(function(\Exception $e, Request $request, $code) {
    return JsonResponse::fromJsonString("", 500);
});


return $app;
