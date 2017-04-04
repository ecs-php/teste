<?php

namespace Service;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\ORMException;

abstract class AbstractRepository extends EntityRepository
{
    /**
     * @param int $id
     * @return null|object
     */
    public function findById($id)
    {
        return parent::findOneBy(['id' => $id]);
    }

    /**
     * @param object $entity
     * @throws ORMException
     * @throws \Exception
     */
    public function save($entity)
    {
        $this->_em->persist($entity);
        $this->_em->flush();
    }

    /**
     * @param object $entity
     * @throws ORMException
     */
    public function delete($entity)
    {
        $this->_em->remove($entity);
        $this->_em->flush();
    }
}
