<?php
/**
 * Created by André Felipe de Souza.
 * Date: 08/03/17 01:00
 */

namespace Common\Entity\Traits;

/**
 * Class IdTrait
 * @package Common\Entity\Traits
 */
trait IdTrait
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
}
