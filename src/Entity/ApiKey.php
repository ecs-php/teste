<?php

namespace Entity;

/**
 * 
 * @Entity
 * @Table(name="api_key")
 */
class ApiKey {

    /**
     * @GeneratedValue(strategy="IDENTITY")
     * @Id @Column(type="integer", unique=true)
     */
    protected $id;

    /**
     * @GeneratedValue(strategy="UUID")
     * @Column(type="string", unique=true)
     */
    protected $key;

    /**
     * @Column(type="integer")
     * @ManyToOne(targetEntity="User")
     * @JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @Column(type="datetime")
     */
    protected $createdAt;

    /**
     * @Column(type="datetime")
     */
    protected $updatedAt;

}
