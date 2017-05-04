<?php

namespace Entity;

/**
 * @Entity
 * @Table(name="user")
 */
class User {

    /**
     * @GeneratedValue(strategy="IDENTITY")
     * @Column(type="integer", unique=true,IDENTITY)     */
    protected $id;

    /** @Column(type="string", length=80) */
    protected $login;

    /** @Column(type="string", length=20) */
    protected $password;

    /** @Column(type="datetime") */
    protected $createAt;

    /** @Column(type="datetime") */
    protected $updateAt;

}
