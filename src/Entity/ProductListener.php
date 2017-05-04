<?php

namespace Entity;

use Doctrine\ORM\Event\PreUpdateEventArgs;

class ProductListener  {

    public function preFlush(Product $product) {
       
       $product->updatedTimestamps();
       return $product;
    }

}
