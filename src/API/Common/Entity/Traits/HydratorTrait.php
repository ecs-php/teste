<?php
/**
 * Created by André Felipe de Souza.
 * Date: 08/03/17 01:22
 */

namespace Common\Entity\Traits;

use Zend\Hydrator\ClassMethods;

/**
 * Class HydratorTrait
 * @package Common\Entity\Traits
 */
trait HydratorTrait
{
    public function hydrate(array $data = array())
    {
        (new ClassMethods())->hydrate($data, $this);
    }

    public function toArray()
    {
        return (new ClassMethods)->extract($this);
    }
}
