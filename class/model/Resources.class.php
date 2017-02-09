<?php

class Resources extends Model
{
    protected static $table = 'resources';
    protected static $fields = array('*'); // visible_fields

    protected $id;
    protected $name;
    protected $age;
    protected $email;
    protected $department;
    protected $salary;
    protected $created_at;
    protected $updated_at;

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

    protected function createFrom($Request)
    {
        $input_data = json_decode(file_get_contents('php://input'), true);

        $required_keys = array('name', 'age', 'email', 'department', 'salary');
        if(!$input_data || array_keys($input_data) !== $required_keys) {
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

    protected function updateFrom($Request)
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
