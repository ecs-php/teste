<?php
namespace Middlewares;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;


/**
 * The TypeValidation class will be responsible to make sure that only requests with the Content-Type as
 * application/json pass through the application flow.
 */
class TypeValidation
{
    /**
     * This method will check the Content-Type of the request header to assure that this request will be 
     * a json/application.If not, will return a JSON string with a message informing this.
     *
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function getContentType(Request $request, Application $app)
    {
        if ($request->headers->get('Content-Type') != 'application/json') {
            return $app->json([
                "success" => false,
                "message" => 'Invalid header Content-Type, you must send only JSON objects.'
            ], 201);
        }else{
            $data = json_decode($request->getContent(), true);
            $request->request->replace((is_array($data)) ? ($data) : []);
        }
    }
}