<?php

class Resources
{
    private static $table = 'resources';

    private $id;
    private $name;
    private $age;
    private $email;
    private $department;
    private $salary;
    private $created_at;
    private $updated_at;

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
                $resource = $this->createFrom($Request);

                $Request->sendResponse(200, $resource);
                break;

            case 'PATCH':
                if(!$Request->getId() || !is_numeric($Request->getId())) {
                    $Request->sendResponse(400);
                }

                $resource = $this->updateFrom($Request);

                $Request->sendResponse(200, $resource);
                break;

            case 'DELETE':
                if(!$Request->getId() || !is_numeric($Request->getId())) {
                    $Request->sendResponse(400);
                }

                $resource = $this->deleteFrom($Request);

                $Request->sendResponse(200, $resource);
                break;

            default:
                $Request->sendResponse(404);
        }
    }

    public function toArray()
    {
        return array(
            'id' => $this->getId(),
            'name' => $this->getName(),
            'age'=> $this->getAge(),
            'email' => $this->getEmail(),
            'department' => $this->getDepartment(),
            'salary' => $this->getSalary(),
            'created_at' => $this->getCreatedAt(),
            'updated_at' => $this->getUpdatedAt()
        );
    }

    private function getAll()
    {
        $rs = DB::getAllFrom(self::$table);

        if(!$rs)
            return array();

        return $rs;
    }

    private function getById($id)
    {
        return DB::getOneByIdFrom(self::getTable(), $id);
    }

    private function createFrom($Request)
    {
        $input_data = json_decode(file_get_contents('php://input'), true);

        $required_keys = array('name', 'age', 'email', 'department', 'salary');
        if(array_keys($input_data) !== $required_keys) {
            $Request->sendResponse(400);
        }

        $this->setName($input_data['name']);
        $this->setAge($input_data['age']);
        $this->setEmail($input_data['email']);
        $this->setDepartment($input_data['department']);
        $this->setSalary($input_data['salary']);

        $now = date('Y-m-d H:i:s');
        $this->setCreatedAt($now);
        $this->setUpdatedAt($now);

        return $this->save();
    }

    private function updateFrom($Request)
    {
        $input_data = json_decode(file_get_contents('php://input'), true);

        $valid_keys = array('name', 'age', 'email', 'department', 'salary');
        if(array_diff(array_keys($input_data), $valid_keys)) {
            $Request->sendResponse(400);
        }

        $resource = $this->getById($Request->getId());
        if(!$resource) {
            $Request->sendResponse(404);
        }

        $this->setId($resource['id']);

        $this->setName($resource['name']);
        if(array_key_exists('name', $input_data))
            $this->setName($input_data['name']);

        $this->setAge($resource['age']);
        if(array_key_exists('age', $input_data))
            $this->setAge($input_data['age']);

        $this->setEmail($resource['email']);
        if(array_key_exists('email', $input_data))
            $this->setEmail($input_data['email']);

        $this->setDepartment($resource['department']);
        if(array_key_exists('department', $input_data))
            $this->setDepartment($input_data['department']);

        $this->setSalary($resource['salary']);
        if(array_key_exists('salary', $input_data))
            $this->setSalary($input_data['salary']);

        $this->setCreatedAt($resource['created_at']);
        $this->setUpdatedAt(date('Y-m-d H:i:s'));

        return $this->save();
    }

    private function deleteFrom($Request)
    {
        $resource = $this->getById($Request->getId());
        if(!$resource) {
            $Request->sendResponse(404);
        }

        return DB::removeFrom(self::getTable(), $resource);
    }

    private function save()
    {
        return DB::saveAt(self::getTable(), $this->toArray());
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

    public function setAge($age)
    {
        $this->age = $age;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setDepartment($department)
    {
        $this->department = $department;
    }

    public function setSalary($salary)
    {
        $this->salary = $salary;
    }

    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
    }

    // GETTERS
    public static function getTable()
    {
        return self::$table;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getAge()
    {
        return $this->age;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getDepartment()
    {
        return $this->department;
    }

    public function getSalary()
    {
        return $this->salary;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function getUpdatedAt()
    {
        return $this->updated_at;
    }
}
