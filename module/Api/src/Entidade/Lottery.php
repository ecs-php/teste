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
     * @return Winner
     */
    public function setDtSorteio($dtSorteio)
    {
        if ( !empty($dtSorteio) )
        {
            $dt_data = str_replace('/', '-', $dtSorteio);

            $this->dt_sorteio = new \DateTime(date('Y-m-d', strtotime($dt_data)));
        }
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

         if ($this->dt_sorteio instanceof \DateTime)
        {

            return $this->dt_sorteio->format('m/y');
        }

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


    /**
     * ToArray
     */
    public function toArray()
    {
        return array(
            'dt_sorteio' => $this->getDtSorteio(),
            'sn_realizado' => $this->getSnRealizado(),
            'id' => $this->getId()
        );
    }
}

