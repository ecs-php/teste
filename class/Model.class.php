<?php

abstract class Model
{
    protected static $table;
    protected static $fields;

    public function __construct($Request)
    {
        switch($Request->getVerb()) {
            case 'GET':
                if($Request->getId()) {
                    if(!is_numeric($Request->getId())) {
                        $Request->sendResponse(400);
                    }

                    $resource = $this->getById($Request->getId());

                    if(!$resource)
                        $Request->sendResponse(404);

                    $Request->sendResponse(200, $resource);
                } else {
                    $resources = $this->getAll();

                    $Request->sendResponse(200, $resources);
                }
                break;

            case 'POST':
                if($Request->getId()) {
                    $Request->sendResponse(400);
                }

                $this->createFrom($Request);
                break;

            case 'PATCH':
                if(!$Request->getId() || !is_numeric($Request->getId())) {
                    $Request->sendResponse(400);
                }

                $this->updateFrom($Request);
                break;

            case 'DELETE':
                if(!$Request->getId() || !is_numeric($Request->getId())) {
                    $Request->sendResponse(400);
                }

                $this->deleteFrom($Request);
                break;

            default:
                $Request->sendResponse(404);
        }
    }

    protected function getAll()
    {
        $rs = DB::getAllFrom(static::getTable(), static::getFields());

        if(!$rs)
            return array();

        return $rs;
    }

    protected function getById($id)
    {
        return DB::getOneByIdFrom(static::getTable(), static::getFields(), $id);
    }

    protected function generateAuthToken($id, $name, $email)
    {
        // Token data
        $token_data = array(
            'id' => $id,
            'name' => $name,
            'email' => $email
        );
        $auth_token = JWT::encode($token_data, API_JWT_SECRET);
        DB::saveAuthTokenFor(Users::getTable(), $id, $auth_token);

        return $auth_token;
    }

    // GETTERS
    public static function getTable()
    {
        return static::$table;
    }

    public static function getFields()
    {
        return static::$fields;
    }
}
