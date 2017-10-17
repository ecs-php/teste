<?php

namespace Api\Entidade;

/**
 * Lottery
 */
class Lottery
{
    /**
     * @var \DateTime
     */
    private $dt_sorteio;

    /**
     * @var integer
     */
    private $sn_realizado;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set dtSorteio
     *
     * @param \DateTime $dtSorteio
     *
     * @return Lottery
     */
    public function setDtSorteio($dtSorteio)
    {
        $this->dt_sorteio = $dtSorteio;

        return $this;
    }

    /**
     * Get dtSorteio
     *
     * @return \DateTime
     */
    public function getDtSorteio()
    {
        return $this->dt_sorteio;
    }

    /**
     * Set snRealizado
     *
     * @param integer $snRealizado
     *
     * @return Lottery
     */
    public function setSnRealizado($snRealizado)
    {
        $this->sn_realizado = $snRealizado;

        return $this;
    }

    /**
     * Get snRealizado
     *
     * @return integer
     */
    public function getSnRealizado()
    {
        return $this->sn_realizado;
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

