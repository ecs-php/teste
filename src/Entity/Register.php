<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @Entity()
 * @Table(name="register")
 */
class Register
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
     * @Column(name="city", type="string", length=255)
     */
    private $city;

    /**
     * @var string
     *
     * @Column(name="state", type="string", length=2)
     */
    private $state;


    /**
     * @var string
     *
     * @Column(name="created_date", type="datetime", length=2)
     */
    private $createdDate;


    /**
     * @var string
     *
     * @Column(name="updated_date", type="datetime", length=2)
     */
    private $updatedDate;



    public function __construct()
    {
        $date = new \DateTime('now');
        $this->setUpdatedDate($date->format('Y-m-d H:i:s'));
        $createsDate = $this->getCreatedDate();
        if(empty($createsDate)){
            $this->setCreatedDate($date->format('Y-m-d H:i:s'));
        }
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
     * @return Register
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
     * @return Register
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     * @return Register
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param string $state
     * @return Register
     */
    public function setState($state)
    {
        $this->state = $state;
        return $this;
    }

    /**
     * @return string
     */
    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    /**
     * @param string $createdDate
     * @return Register
     */
    public function setCreatedDate($createdDate)
    {
        $this->createdDate = $createdDate;
        return $this;
    }

    /**
     * @return string
     */
    public function getUpdatedDate()
    {
        return $this->updatedDate;
    }

    /**
     * @param string $updatedDate
     * @return Register
     */
    public function setUpdatedDate($updatedDate)
    {
        $this->updatedDate = $updatedDate;
        return $this;
    }




    public function serialize()
    {
        return array(
            'id' => $this->getId(),
            'name' => $this->getName(),
            'city' => $this->getCity(),
            'state' => $this->getState(),
            'createdDate' => $this->getCreatedDate(),
            'updatedDate' => $this->getUpdatedDate()
        );
    }

    public function setAll($sets)
    {
        foreach ($sets as $key=>$set)
        {
            if($key != 'createdDate' && $key != 'updatedDate') {
                $object = 'set' . ucfirst($key);
                $this->$object($set);
            }
        }
    }

}