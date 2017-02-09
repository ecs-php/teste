<?php

class Users extends Model
{
    protected static $table = 'users';
    protected static $fields = array('id', 'name', 'email'); // visible_fields

    protected $id;
    protected $name;
    protected $email;
    protected $password;
    protected $auth_token;

    public function toArray()
    {
        return array(
            'id' => $this->getId(),
            'name' => $this->getName(),
            'email' => $this->getEmail(),
            'password' => $this->getPassword(),
            'auth_token' => $this->getAuthToken()
        );
    }

    protected function createFrom($Request)
    {
        $input_data = json_decode(file_get_contents('php://input'), true);

        // Validate
        $required_keys = array('name', 'email', 'password');
        if(!$input_data || array_keys($input_data) !== $required_keys) {
            $Request->sendResponse(400);
        }
        if(!filter_var($input_data['email'], FILTER_VALIDATE_EMAIL)) {
            echo "INVALID EMAIL";
            $Request->sendResponse(400);
        }
        if(DB::getOneByField(self::getTable(), 'email', $input_data['email'])) {
            $Request->sendResponse(409);
        }
        if(strlen($input_data['password']) < 6) {
            $Request->sendResponse(400);
        }

        $this->setName($input_data['name']);
        $this->setEmail($input_data['email']);
        $this->setPassword($input_data['password']);

        return $this->save();
    }

    protected function updateFrom($Request)
    {
        $input_data = json_decode(file_get_contents('php://input'), true);

        $valid_keys = array('name', 'email');
        if(array_diff(array_keys($input_data), $valid_keys)) {
            $Request->sendResponse(400);
        }

        $resource = DB::getOneByIdFrom(static::getTable(), array('*'), $Request->getId());
        if(!$resource) {
            $Request->sendResponse(404);
        }

        $this->setId($resource['id']);

        $this->setName($resource['name']);
        if(array_key_exists('name', $input_data))
            $this->setName($input_data['name']);

        $this->setEmail($resource['email']);
        if(array_key_exists('email', $input_data))
            $this->setEmail($input_data['email']);

        $this->setPassword($resource['password']);
        $this->setAuthToken($resource['auth_token']);

        return $this->save();
    }

    protected function deleteFrom($Request)
    {
        $resource = $this->getById($Request->getId());
        if(!$resource) {
            $Request->sendResponse(404);
        }

        return DB::removeFrom(self::getTable(), $resource);
    }

    protected function save()
    {
        $item = DB::saveAt(self::getTable(), $this->toArray());

        foreach(array_diff(array_keys($item), self::getFields()) as $skip) {
            unset($item[$skip]);
        }

        return $item;
    }

    // SETTERS
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setPassword($password)
    {
        $this->password = sha1($password);
    }

    public function setAuthToken($token)
    {
        $this->tokens[] = $token;
    }

    // GETTERS
    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getAuthToken()
    {
        return $this->auth_token;
    }
}
