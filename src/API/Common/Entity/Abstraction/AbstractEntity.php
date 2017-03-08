<?php

/**
 * Created by André Felipe de Souza.
 * Date: 08/03/17 01:02
 */

namespace Common\Entity\Abstraction;

use \Common\Entity\Traits\IdTrait;
use \Common\Entity\Traits\DateTrait;
use \Common\Entity\Traits\HydratorTrait;

/**
 * Class AbstractEntity
 * @package Common\Entity
 */
abstract class AbstractEntity
{
    use IdTrait;
    use DateTrait;
    use HydratorTrait;

    /**
     * AbstractEntity constructor.
     * @param array|null $data
     */
    public function __construct(array $data = null)
    {
        if (!is_null($data)) {
            $this->hydrate($data);
        }
    }
}
