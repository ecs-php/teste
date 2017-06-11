<?php

class Login extends Model
{
    public function __construct($Request)
    {
        switch($Request->getVerb()) {
            case 'POST':
                if($Request->getId()) {
                    $Request->sendResponse(400);
                }

                $this->validateCredentials($Request);
                break;
        }
    }

    protected function validateCredentials($Request)
    {
        $input_data = json_decode(file_get_contents('php://input'), true);
        $input_data['password'] = sha1($input_data['password']);

        // Validate
        $required_keys = array('email', 'password');
        if(!$input_data || array_keys($input_data) !== $required_keys) {
            $Request->sendResponse(400);
        }

        $resource = DB::getOneByField(Users::getTable(), $input_data);

        if(!$resource)
            $Request->sendResponse(401);

        $auth_token = $this->generateAuthToken($resource['id'], $resource['name'], $resource['email']);

        $clean = $this->cleanOutputFields($resource);
        $Request->sendResponse(200, $clean, array("x-auth: {$auth_token}"));
    }
    
    private function cleanOutputFields($resource)
    {
        foreach(array_diff(array_keys($resource), Users::getFields()) as $skip) {
            unset($resource[$skip]);
        }

        return $resource;
    }
}
