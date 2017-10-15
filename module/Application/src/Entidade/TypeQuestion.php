<?php

namespace Application\Entidade;

/**
 * TypeQuestion
 */
class TypeQuestion {
    /**
     * @var string
     */
    private $name;

    /**
     * @var integer
     */
    private $id;

    /**
     * Set name
     *
     * @param string $name
     *
     * @return TypeQuestion
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * ToArray
     */
    public function toArray() {
        return array(
            'id' => $this->getId(),
            'name' => $this->getName(),
        );
    }
}
