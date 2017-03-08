<?php

/**
 * Created by André Felipe de Souza.
 * Date: 08/03/17 02:09
 */

namespace Person\Services\Retrieve;

use Common\Services\Retrieve\AbstractRetrieve;
use Doctrine\ORM\EntityRepository;

/**
 * Class PersonRetrieve
 * @package Person\Services\Retrieve
 */
class PersonRetrieve extends AbstractRetrieve
{
    /**
     * @return EntityRepository
     */
    public function getEntityRepository()
    {
        return $this->entityRepository;
    }
}
