<?php

namespace Application\Entidade;

/**
 * Quiz
 */
class Quiz
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $description;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set name
     *
     * @param string $name
     *
     * @return Quiz
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Quiz
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Quiz
     */
    public function setCreatedAt($createdAt)
    {

        if ( !empty($createdAt) )
        {
            $dt_data = str_replace('/', '-', $createdAt);

            $this->$createdAt = new \DateTime(date('Y-m-d H:i:s', strtotime($dt_data)));
        }

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        if ($this->createdAt instanceof \DateTime)
        {
            return $this->createdAt->format('d/m/Y H:i:s');
        }
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Quiz
     */
    public function setUpdatedAt($updatedAt)
    {
        if ( !empty($updatedAt) )
        {
            $dt_data = str_replace('/', '-', $updatedAt);

            $this->$updatedAt = new \DateTime(date('Y-m-d', strtotime($dt_data)));
        }

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        if ($this->updatedAt instanceof \DateTime)
        {
            return $this->updatedAt->format('d/m/Y H:i:s');
        }
        return $this->updatedAt;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }


    public function toArray()
    {
        return array(
            'id'=> $this->getId(),
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'create_at' => $this->getCreatedAt(),
            'update_at' => $this->getUpdatedAt(),
        );
    }
}

