<?php

namespace Entity;

/**
 * 
 * @Entity(repositoryClass="Repository\ApiKeyRepository") @EntityListeners({"ApiKeyListener"})
 * @Entity
 * @Table(name="api_key")
 * 
 */
class ApiKey {

    /**
     * @GeneratedValue(strategy="IDENTITY")
     * @Id @Column(type="integer", unique=true)
     */
    protected $id;

    /**
     *
     * @Column(type="string", unique=true)
     */
    protected $key;

    /**
     * @Column(type="integer")
     * @ManyToOne(targetEntity="User")
     * @JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user_id;

    /**
     * @Column(type="datetime")
     */
    protected $createdAt;

    /**
     * @Column(type="datetime")
     */
    protected $updatedAt;

    public function getId() {
        return $this->id;
    }

    public function getKey() {
        return $this->key;
    }

    public function getUser_id() {
        return $this->user_id;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }

    public function getUpdatedAt() {
        return $this->updatedAt;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setKey($key) {
        $this->key = $key;
    }

    public function setUser_id($user_id) {
        $this->user_id = $user_id;
    }

    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;
    }

    public function setUpdatedAt($updatedAt) {
        $this->updatedAt = $updatedAt;
    }

    public function updatedTimestamps() {
        $this->setUpdatedAt(new \DateTime('now'));

        if ($this->getCreatedAt() == null) {
            $this->setCreatedAt(new \DateTime('now'));
        }
    }
    
    public function createKey(){
        if ($this->getKey() == null) {
            $this->setKey(uniqid("key_",true));            
        }
    }

}
