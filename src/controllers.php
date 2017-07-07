<?php
/**
 * Created by PhpStorm.
 * User: mauricioschmitz
 * Date: 6/5/17
 * Time: 22:10
 */

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Middleware\Logging as AppLogging;
use App\Middleware\Authentication as AppAuth;
use App\Models\Message;
use App\Models\User;

//Authentication;
$app->before(function($request, $app) use ($app) {
    //Verify if content type is json
    if (strpos($request->headers->get('Content-Type'), 'application/json')!==0) {
        return $app->json(array('error' => 'Invalid Header Content-Type'), 201);
    }else{
        $data = json_decode($request->getContent(), true);
        $request->request->replace(is_array($data) ? $data : array());
    }
    //Log usage
    AppLogging::log($request, $app);
    //Authenticate
    AppAuth::authenticate($request, $app);
});

//Group api routes
$app->mount('/api/v1', function ($api) use ($app){
    //List of messages from user request
    $api->get('/messages', function (Request $request)  use ($app) {
        //find messages from authenticated user
        $message = Message::where('user_id', $request->attributes->get('user_id'))->with('user')->get();
        //return a json result
        return $app->json($message, 201);
    });

    //Find one message by id
    $api->get('/message/{id}', function (Request $request, $id)  use ($app) {
        //find message from authenticated user and request id
        $message = Message::where('user_id', $request->attributes->get('user_id'))->where('id', $id)->with('user')->get();
        //return a json result
        return $app->json($message, 201);
    });

    //Create a message from user request
    $api->post('/message', function (Request $request)  use ($app) {
        try{
            $user = User::where('id', $request->attributes->get('user_id'))->first(['id', 'name', 'email']);
            $message = new Message($request->request->all());
            $message->user()->associate($user);
            $message->save();
        }catch (Exception $ex){
            return $app->json(array('error' => 'Invalid data sent'), 201);
        }
        unset($message->user->password);
        unset($message->user->apikey);
        unset($message->user->active);
        unset($message->user->updat);
        return $app->json($message, 201);
    });

    //Update a message from user request
    $api->put('/message', function (Request $request)  use ($app) {
        try{
            $user = User::findOrNew($request->attributes->get('user_id'));
            $message = Message::where('user_id', $request->attributes->get('user_id'))->where('id', $request->request->get('id'))->first();
            if(!is_null($message)) {
                $message->update($request->request->all());
            }else{
                return $app->json(array('error' => 'Message not found'), 201);
            }
        }catch (Exception $ex){
            return $app->json(array('error' => 'Invalid data sent'), 201);
        }
        return $app->json($message, 201);
    });

    //Delete one message by id
    $api->delete('/message/{id}', function (Request $request, $id)  use ($app) {
        //find message from authenticated user and request id
        $message = Message::where('user_id', $request->attributes->get('user_id'))->where('id', $id)->first();
        if(!is_null($message)){
            $message->delete();
            return $app->json(array('success' => 'Deleted'), 201);
        }else{
            return $app->json(array('error' => 'Message not found'), 201);
        }

    });
});


$app->error(function (\Exception $e, Request $request, $code) use ($app) {
    if ($app['debug']) {
        return;
    }

    return $app->json(array('error' => 'An error ocurred, please check the API documentation'), $code);
});
