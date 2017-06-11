<?php

namespace TESTE\Entity;

/**
 * Description of Pessoa
 *
 * @author pandacoder
 * @Entity 
 */
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="person")
 */
class Person
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50, unique=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=64)
     */function getId() {
        return $this->id;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getFacebook() {
        return $this->facebook;
    }

    public function getTwitter() {
        return $this->twitter;
    }

    public function getCreated() {
        return $this->created;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setFacebook($facebook) {
        $this->facebook = $facebook;
    }

    public function setTwitter($twitter) {
        $this->twitter = $twitter;
    }

    public function setCreated($created) {
        $this->created = $created;
    }
    
    public function setName($name) {
        $this->name = $name;
    }
    
    public function setPhone($phone) {
        $this->phone = $phone;
    }
    
    /**
     * @ORM\Column(type="string", length=60, unique=true)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=60, unique=true)
     */
    private $email;
    
    /**
     * @ORM\Column(type="string", length=60, unique=true)
     */
    private $facebook;
    
    /**
     * @ORM\Column(type="string", length=60, unique=true)
     */
    private $twitter;
    
    /**
     * @ORM\Column(type="datetime", length=60, unique=true)
     */
    private $created;
    
     /**
     * @ORM\Column(type="datetime", length=60, unique=true)
     */
    private $updated;
    
    
    
    public function setUpdated()
    {
        $this->updated = new \DateTime("now");
    }

    public function __construct()
    {
       $this->created = new \DateTime("now");
    }

    public function getName()
    {
        return $this->name;
    }


    public function getPhone()
    {
        return $this->phone;
    }

    public function toArray()
    {
        return array(
            'id'=> $this->id,
            'name'=> $this->name,
            'email'=> $this->email,
            'phone'=> $this->phone,
            'facebook'=> $this->facebook,
            'twitter'=> $this->twitter,
            'created'=> $this->created,
            'updated'=> $this->updated,
        );
    }
}