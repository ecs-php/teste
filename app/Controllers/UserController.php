<?php

namespace App\Controllers;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Silex\Application;
use App\Models\User;

class UserController
{
    public function __construct()
    {
        
    }

    public function index(Application $app, Request $request)
    {
        $users = User::all();
        return $app->json(
            [
                'msg' => "Success when list user all",
                'data' => $users
            ], 200, ['Content-Type' => 'application/json']
        );
    }

    public function find(Application $app, Request $request, $id)
    {
        $user = User::find($id);

        if ( !$user ) {
            throw new Exception("User not found", 404);
        }

        return $app->json(
            [
                'msg' => "Success, found user",
                'data' => $user
            ], 200, ['Content-Type' => 'application/json']
        );
    }

    public function create(Application $app, Request $request)
    {
        $data = $request->request->all();
        $password = crypt($data['password']);
        $code = rand(000000000000, 999999999999)."-".rand(0, 9);
        $user = new User($data);
        $user->password = $password;
        $user->code = $code;

        try {
            $user->save();
        }catch (Exception $exception){
            throw new Exception("Fields: name, email, phone, city and password are required!", 400);
        }


        return $app->json(
            [
                'msg' => "Success when register user",
                'data' => $user
            ], 201, ['Content-Type' => 'application/json']
        );
    }

    public function update(Application $app, Request $request, $id)
    {
        $user = User::find($id);
        if ( !$user ) {
            throw new Exception("User not found", 404);
        }
        $data = $request->request->all();
        $password = crypt($data['password']);
        $user->fill($data);
        $user->password = $password;
        $user->save();

        return $app->json(
            [
                'msg' => "Success when update user",
                'data' => $user
            ], 200, ['Content-Type' => 'application/json']
        );
    }

    public function delete(Application $app, Request $request, $id)
    {
        $user = User::find($id);
        if ( !$user ) {
            throw new Exception("User not found", 404);
        }
        $user->delete();

        return $app->json(
            [
                'msg' => "Success when deleting user",
                'data' => $user
            ], 204, ['Content-Type' => 'application/json']
        );

    }
}
