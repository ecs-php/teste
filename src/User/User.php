<?php
namespace Test\User;

use Test\Entity\Entity; 
use Test\Entity\EntityInterface; 

class User implements EntityInterface
{
	private $entity;

	public function __construct(Entity $entity)
	{
		$this->entity = $entity;
        
		$this->entity->setTable('users');
	}

	public function getEntity()
	{
		return $this->entity;
	}
}