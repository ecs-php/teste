<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Book;

$app->before('app.authentication');

$app->get('/book', function () use($app) {
    $repository = $app['orm.em']->getRepository(App\Entity\Book::class);
    $books = $repository->findAll();
    return JsonResponse::fromJsonString($app['serializer']->serialize($books, 'json'));
})->before('app.validator.accept');

$app->get('/book/{book}', function ($book) use($app) {
    return JsonResponse::fromJsonString($app['serializer']->serialize($book, 'json'));
})->before('app.validator.accept')->convert('book', 'app.converter.book');

$app->post('/book', function (Request $request) use($app) {
    $param = $app['serializer']->deserialize($request->getContent(), Book::class, 'json');
    $book = $app['app.service.book']->create($param);
    return JsonResponse::fromJsonString($app['serializer']->serialize($book, 'json'), Response::HTTP_CREATED);
})->before('app.validator.accept')->before('app.validator.contentType');

$app->patch('/book/{id}', function (Request $request, $id) use($app) {
    $param = $app['serializer']->deserialize($request->getContent(), Book::class, 'json');
    $book = $app['app.service.book']->update($id, $param);
    return JsonResponse::fromJsonString($app['serializer']->serialize($book, 'json'));
})->before('app.validator.accept')->before('app.validator.contentType');

$app->delete('/book/{id}', function ($id) use($app) {
    $book = $app['app.service.book']->delete($id);
    return JsonResponse::fromJsonString($app['serializer']->serialize($book, 'json'));
})->before('app.validator.accept');