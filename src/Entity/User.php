<?php

namespace Entity;

/**
 * @Entity(repositoryClass="Repository\UserRepository") @EntityListeners({"UserListener"})
 * @Table(name="user")
 */
class User {

    /**
     * @GeneratedValue(strategy="IDENTITY")
     * @Id  @Column(type="integer", unique=true)     */
    protected $id;

    /** @Column(type="string", length=80) */
    protected $login;

    /** @Column(type="string", length=20) */
    protected $password;

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

    public function getLogin() {
        return $this->login;
    }

    public function getPassword() {
        return $this->password;
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

    public function setLogin($login) {
        $this->login = $login;
    }

    public function setPassword($password) {
        $this->password = $password;
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

}
