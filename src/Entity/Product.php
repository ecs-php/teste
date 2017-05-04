<?php

namespace Entity;

/**
 * @Entity
 * @Table(name="product")
 */
class Product {
    
    /**
     * @GeneratedValue(strategy="IDENTITY")
     * @Column(type="integer", unique=true,IDENTITY)
     */
    protected $id;
    /** @Column(type="string") */
    protected $name;
    /** @Column(type="text") */
    protected $description;
    /** @Column(type="decimal") */
    protected $price;    
    /** @Column(type="string") */
    protected $category;
    /** @Column(type="datetime") */
    protected $create_at;
    /** @Column(type="datetime") */
    protected $update_at;
}
