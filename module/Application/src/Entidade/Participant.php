<?php

namespace Application\Entidade;

/**
 * Participant
 */
class Participant
{
    /**
     * @var string
     */
    private $email;

    /**
     * @var \DateTime
     */
    private $createAt = 'CURRENT_TIMESTAMP';

    /**
     * @var integer
     */
    private $id;


    /**
     * Set email
     *
     * @param string $email
     *
     * @return Participant
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set createAt
     *
     * @param \DateTime $createAt
     *
     * @return Participant
     */
    public function setCreateAt($createAt)
    {
        $this->createAt = $createAt;

        return $this;
    }

    /**
     * Get createAt
     *
     * @return \DateTime
     */
    public function getCreateAt()
    {
        return $this->createAt;
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
}

