<?php

namespace Serasa\Model;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

abstract class Entity {
    
    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @var integer
     */
    protected $id;

    /**
     * @ORM\Column(type="datetime")
     * @var datetime
     */
    protected $created;

    /**
     * @ORM\Column(type="datetime",nullable=true)
     * @var datetime
     */
    protected $updated;

    /**
     * Constructor
     */
    public function __construct(){
        $this->created = new DateTime();
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getCreated(){
        if (!is_null($this->created)) {
            return $this->created->format(\DateTime::ISO8601);
        }
        return $this->created;
    }

    public function setCreated($created){
        if (is_object($created)) {
            return $this->created = $created;
        }

        $this->created = \DateTime::createFromFormat(\DateTime::ISO8601, $created);
    }

    public function getUpdated() {
        if(is_null($this->updated)) {
            return null;
        }
        return $this->updated->format(\DateTime::ISO8601);
    }

    public function setUpdated($updated) {
        if (is_object($updated)) {
            return $this->updated = $updated;
        }
        $this->updated = \DateTime::createFromFormat(\DateTime::ISO8601, $updated);
    }
}