<?php

namespace TestRest\Contact;

use TestRest\Entity\Entity;
use TestRest\Entity\EntityInterface;

class Contact implements EntityInterface {

  private $entity;

  /**
   * 
   * @param Entity $entity
   */
  public function __construct(Entity $entity) {
    $this->entity = $entity;

    $this->entity->setTable('contact');
    $this->entity->setIdTable('id_contact');
  }

  /**
   * 
   * @return entity
   */
  public function getEntity() {
    return $this->entity;
  }

}
