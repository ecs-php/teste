<?php

namespace Repository;

use Entity\Product;
use Doctrine\ORM\EntityRepository;
//use Doctrine\ORM\Query;

class ProductRepository extends EntityRepository {

    public function findAllProductsToArray() {
        return $this->findAll();
    }

    public function findProductByName($name) {
        return $this->findOneBy(['name' => $name]);
    }
    public function findById($id) {
        return $this->findOneBy(['id' => $id]);
    }

}
