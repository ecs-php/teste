<?php

/**
 * Created by André Felipe de Souza.
 * Date: 08/03/17 02:37
 */

namespace Common\Services\Persist;

use Common\Entity\Abstraction\AbstractEntity;
use Doctrine\ORM\EntityManager;

/**
 * Class AbstractPersist
 * @package Common\Services\Persist
 */
class AbstractPersist
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param AbstractEntity $entity
     * @return AbstractEntity
     */
    protected function create(AbstractEntity $entity)
    {
        if (empty($entity->getCreatedAt())) {
            $entity->setCreatedAt(new \DateTime());
        }

        $this->entityManager->persist($entity);
        return $entity;
    }

    /**
     * @param AbstractEntity $entity
     * @return AbstractEntity
     */
    protected function update(AbstractEntity $entity)
    {
        $entity->setUpdatedAt(new \DateTime());
        $this->entityManager->persist($entity);
        return $entity;
    }

    /**
     * @param AbstractEntity $entity
     * @return AbstractEntity
     */
    protected function delete(AbstractEntity $entity)
    {
        $entity->setDeletedAt(new \DateTime());
        $this->entityManager->persist($entity);
        return $entity;
    }

    /**
     * @param AbstractEntity $entity
     * @return AbstractEntity
     * @throws \Exception
     */
    protected function remove(AbstractEntity $entity)
    {
        $this->entityManager->remove($entity);
        return $entity;
    }
}
