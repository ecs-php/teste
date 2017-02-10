<?php

class Request
{
    private static $valid_endpoints = array('resources', 'users', 'login');

    private $endpoint;
    private $id;
    private $verb;

    public function __construct()
    {
        $this->verb = $_SERVER['REQUEST_METHOD'];
    }

    public function handle()
    {

        // Receives only JSON content
        if(array_key_exists('CONTENT_TYPE', $_SERVER) && $_SERVER['CONTENT_TYPE'] !== 'application/json') {
            $this->sendResponse(400);
        }

        $this->resolveUrl();
        $this->validateAuthToken();

        if(!in_array($this->getEndpoint(), self::$valid_endpoints))
            $this->sendResponse(400);

        // Create object and manipulate response
        $class = ucwords($this->endpoint);
        new $class($this);
    }

    public function sendResponse($status_code, $response_body=null, $additional_headers=array())
    {
        header("HTTP/1.0 {$status_code}", true, $status_code);
        foreach ($additional_headers as $header) {
            header($header);
        }

        if($response_body)
            echo json_encode($response_body);

        die;
    }

    private function resolveUrl()
    {
        if(!array_key_exists('url', $_GET)) {
            $this->sendResponse(404);
        }

        $pieces = explode('/', $_GET['url']);

        if(count($pieces) > 2) {
            $this->sendResponse(400);
        }

        $this->endpoint = $pieces[0];
        if(array_key_exists(1, $pieces)) {
            $this->id = $pieces[1];
        }
    }

    private function validateAuthToken()
    {
        // Set bypass authentication
        if(($this->getEndpoint() === 'users' && !$this->getId()) || $this->getEndpoint() === 'login') {
            return;
        }

        if(!array_key_exists('HTTP_X_AUTH', $_SERVER))
            $this->sendResponse(401);

        $auth_token = $_SERVER['HTTP_X_AUTH'];
        try{
            $token_data = JWT::decode($auth_token, API_JWT_SECRET, array('HS256'));
        } catch(Exception $e) {
            $this->sendResponse(401);
        }

        $fields = array(
            'name' => $token_data->name,
            'email' => $token_data->email,
            'auth_token' => $auth_token,
        );
        $resource = DB::getOneByField(Users::getTable(), $fields);

        if(!$resource)
            $this->sendResponse(401);
    }


    // GETTERS
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getVerb()
    {
        return $this->verb;
    }
}
