<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @Entity()
 * @Table(name="users")
 */
class User
{

    /**
     * @var integer
     *
     * @Column(name="id", type="integer")
     * @Id()
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @Column(name="username", type="string", length=255, unique=true)
     */
    private $username;

    /**
     * @var string
     *
     * @Column(name="password", type="string", length=64)
     */
    private $password;

    /**
     * @var string
     *
     * @Column(name="email", type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @var string
     *
     * @Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     * @var string
     */
    private $salt;

    public function __construct()
    {
        $this->isActive = true;
        $this->salt = md5(uniqid('DV^WSXZ!*uo_n)(mxRhb@gHplmUO*WE$W_N_8z9BSdbRJ#oNaBOa!Ov&$UL@KSrV', true));
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return User
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {

        $this->password = password_hash($password, PASSWORD_BCRYPT, array(
            'cost' => 12,
            'salt' => $this->getSalt()
        ));
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getisActive()
    {
        return $this->isActive;
    }

    /**
     * @param string $isActive
     * @return User
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
        return $this;
    }

    /**
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    public function password_verify($password, $hash){
        if(password_verify($password, $hash)){
            return true;
        } else {
            return false;
        }
    }


    public function serialize()
    {
        return array(
            'id' => $this->getId(),
            'name' => $this->getName(),
            'username' => $this->getUsername(),
            'password' =>$this->getPassword(),
            'email' => $this->getEmail(),
            'is_active' => $this->getisActive()
        );
    }

    public function setAll($sets)
    {
        foreach ($sets as $key=>$set)
        {
            if($key != 'is_active') {
                $object = 'set' . ucfirst($key);
                $this->$object($set);
            }
        }
    }

}