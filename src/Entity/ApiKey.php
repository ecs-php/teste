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
     * @Column(type="integer", unique=true,IDENTITY)
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
    
    /** @Column(type="datetime") */
    protected $create_at;
    
    /** @Column(type="datetime") */
    protected $update_at;
}
