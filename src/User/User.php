<?php

namespace TestRest\User;

use TestRest\Entity\Entity;
use TestRest\Entity\EntityInterface;

class User implements EntityInterface {

  private $entity;

  /**
   * 
   * @param Entity $entity
   */
  public function __construct(Entity $entity) {
    $this->entity = $entity;

    $this->entity->setTable('user');
    $this->entity->setIdTable('id_user');
  }

  /**
   * 
   * @return entity
   */
  public function getEntity() {
    return $this->entity;
  }

  /**
   * 
   * @return token login
   */
  public function login($email, $password) {
    $user['email'] = (string) empty($email) ? null : $email;
    $user['password'] = (string) empty($password) ? null : $password;

    return $this->getEntity()->where($user);
  }

}
