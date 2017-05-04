<?php

namespace Entity;

/**
 * @Entity
 * @Table(name="product")
 */
class Product {

    /**
     * @GeneratedValue(strategy="IDENTITY")
     * @Id @Column(type="integer", unique=true)
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

    public function getName() {
        return $this->name;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getCategory() {
        return $this->category;
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

    public function setName($name) {
        $this->name = $name;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function setCategory($category) {
        $this->category = $category;
    }

    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;
    }

    public function setUpdatedAt($updatedAt) {
        $this->updatedAt = $updatedAt;
    }



}
