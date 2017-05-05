<?php

namespace Repository;

use Doctrine\ORM\EntityRepository;
use Entity\User;

class UserRepository extends EntityRepository {

    public function findAllUsers() {
        return $this->findAll();
    }

    public function findUser($login) {
        return $this->findOneBy(['login' => $login]);
    }
    public function findUserById($id) {
        return $this->findOneBy(['id' => $id]);
    }

    

}
