<?php

/**
 * Created by André Felipe de Souza.
 * Date: 08/03/17 02:07
 */

namespace Common\Services\Retrieve;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;

/**
 * Class AbstractRetrieve
 * @package Common\Services\Retrieve
 */
abstract class AbstractRetrieve
{
    /**
     * @var EntityRepository
     */
    protected $entityRepository;

    /**
     * @param EntityRepository $entityRepository
     */
    public function __construct(EntityRepository $entityRepository)
    {
        $this->entityRepository = $entityRepository;
    }

    /**
     * @return EntityRepository
     */
    abstract protected function getEntityRepository();

    /**
     * @return ArrayCollection
     */
    public function retrieveAll()
    {
        return new ArrayCollection($this->entityRepository->findBy(['deletedAt' => null]));
    }

    /**
     * @param $id
     * @return null|object
     */
    public function retrieveById($id)
    {
        $entity = $this->entityRepository->findOneBy(['id' => $id, 'deletedAt' => null]);
        return $entity;
    }
}
