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
 * @ORM\Table(name="user")
 */
class User
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
    private $username;

    /**
     * @ORM\Column(type="string", length=50, unique=true)
     */
    private $token;

    /**
     * @ORM\Column(type="string", length=64)
     */
    function getId()
    {
        return $this->id;
    }

    public function getEmail()
    {
        return $this->email;
    }


    public function getCreated()
    {
        return $this->created;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }


    public function setCreated($created)
    {
        $this->created = $created;
    }

    public function setUserName($username)
    {
        $this->username = $username;
    }




    /**
     * @ORM\Column(type="string", length=60, unique=true)
     */
    private $email;



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
        $this->token   = bin2hex(openssl_random_pseudo_bytes(8)); //generate a random token
    }

    public function getUserName()
    {
        return $this->username;
    }


    public function getToken()
    {
        return $this->token;
    }

    public function toArray()
    {
        return array(
            'id'       => $this->id,
            'username' => $this->username,
            'email'    => $this->email,
            'token'    => $this->token,
            'created'  => $this->created,
            'updated'  => $this->updated,
        );
    }
}