<?php
namespace Middlewares;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;


/**
 * The Authentication class is responsible to validate if an access to the api is a valid one by
 * checking if a Authorization code exists in the database table users.
 * 
 * @package Middlewares
 */
class Authentication
{
    /**
     * Method responsible to validate the Authorization code on the request header.
     * It will return a JSON string if the authorization code doesn't exist on the database.
     *
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public static function authenticate(Request $request, Application $app)
    {
        $authkey = $request->headers->get("Authorization");

        $authorized = $app['db']->fetchAssoc("SELECT id FROM users WHERE authkey = ?", [$authkey]);
        if (!$authorized) {
            return $app->json([
                "success" => false, 
                "message" => "You have no permission to access this resource."
            ], 401);
        }
    }
}
