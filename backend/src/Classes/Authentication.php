<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 01/09/17
 * Time: 22:39
 */

namespace Classes;

use Classes\UserRepository;

class Authentication
{
    private $app;
    private $request;

    private static $authentication = null;
    public static function get()
    {
        if (self::$authentication == null) {
            self::$authentication = new Authentication();
        }
        return self::$authentication;
    }

    public function init($request, $app)
    {
        $this->request = $request;
        $this->app = $app;
    }

    public function authenticate()
    {
        $auth = $this->request->headers->get("Authorization");
        $apikey = substr($auth, strpos($auth, ' '));
        $apikey = trim($apikey);

        $user = UserRepository::get()->getByAPIKey($apikey);
        if(!$user) {
            $this->app->abort(401);
        }

        $last_connection = $user['last_connection'];
        $last_connection = date_create_from_format("Y-m-d H:i:s",$last_connection);
        $date = new \DateTime('now');


//        if($date->getTimestamp() - $last_connection->getTimestamp() > 1*60*60){
//            $this->app->abort(401);
//        }


        UserRepository::get()->updateLastConnetion( $user["id"]);

        $this->request->attributes->set("id_user",$user["id"]);
    }


    public function login()
    {
        $data = json_decode($this->request->getContent(),true);

        $email = $data['email'];
        $password = md5($data['password']);

        $user = UserRepository::get()->getByEmailPassword($email, $password);
        if(!$user) {
            $this->app->abort(401);
        }

        $apikey= uniqid("",true).uniqid("",true);
        UserRepository::get()->updateApiKey($apikey, $user["id"]);
        UserRepository::get()->updateLastConnetion( $user["id"]);

        return json_encode(array("apikey" => $apikey));

    }
}