<?php

namespace Repository;

use Entity\Product;
use Doctrine\ORM\EntityRepository;

class ApiKeyRepository extends EntityRepository {

    function findKeyAtiveByUser($user_id) {
        return $this->findOneBy(["user_id" => $user_id], ['id' => "desc"]);
    }

    public function findOneByKey($key) {
        return $this->findOneBy(["key" => $key]);
    }

}
