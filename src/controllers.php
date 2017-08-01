<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Silex\Application;

// First of all, we define the middleware who's going to validate with this request have a valid authorization code 
$app->before('Middlewares\\Authentication::authenticate', Application::EARLY_EVENT);

// This is the route to the index of the application.
$app->get('/', function() use ($app) {
    return 'index...';
})->bind('homepage');

// This is the route that return the list of all people of the database
$app->get('api/v1/people', 'Controllers\\PeopleController::index')->bind('getList');

// This route is responsible to return the information about one person, informed by its id.
$app->get('api/v1/people/{id}', 'Controllers\\PeopleController::get')->bind('getPeople');

// This route is responsible to insert a new person in the database. The TypeValidation middleware will make sure that the content-type is a json object.
$app->post('api/v1/people', 'Controllers\\PeopleController::insert')->bind('postPeople')->before('Middlewares\\TypeValidation::getContentType', Application::EARLY_EVENT);

// This route will update the information about a person, it will validate the content-type through the TypeValidation middleware
$app->put('api/v1/people', 'Controllers\\PeopleController::update')->bind('putPeople')->before('Middlewares\\TypeValidation::getContentType', Application::EARLY_EVENT);

// The delete route will make sure to erase the register from the database informed by its id.
$app->delete('api/v1/people/{id}', 'Controllers\\PeopleController::delete')->bind('deletePeople');


$app->error(function (\Exception $e, Request $request, $code) use ($app) {
    if ($app['debug']) {
        return;
    }

    // 404.html, or 40x.html, or 4xx.html, or error.html
    $templates = array(
        'errors/'.$code.'.html.twig',
        'errors/'.substr($code, 0, 2).'x.html.twig',
        'errors/'.substr($code, 0, 1).'xx.html.twig',
        'errors/default.html.twig',
    );

    return new Response($app['twig']->resolveTemplate($templates)->render(array('code' => $code)), $code);
});