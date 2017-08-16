<?php

namespace Serasa\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
*/
class User extends Entity {

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=11)
     * @var string
     */
    private $age;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $address;

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getAge() {
        return $this->age;
    }

    public function setAge($age) {
        $this->age = $age;
    }

    public function getAddress() {
        return $this->address;
    }

    public function setAddress($address) {
        $this->address = $address;
    }
}