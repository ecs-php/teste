<?php

namespace Api\Entidade;

/**
 * Winner
 */
class Winner
{
    /**
     * @var interger
     */
    private $nr_sorteio;

    /**
     * @var \DateTime
     */
    private $dt_sorteio;

    /**
     * @var string
     */
    private $ds_cidade;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set nrSorteio
     *
     * @param \interger $nrSorteio
     *
     * @return Winner
     */
    public function setNrSorteio(\interger $nrSorteio)
    {
        $this->nr_sorteio = $nrSorteio;

        return $this;
    }

    /**
     * Get nrSorteio
     *
     * @return \interger
     */
    public function getNrSorteio()
    {
        return $this->nr_sorteio;
    }

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
     * Set dsCidade
     *
     * @param string $dsCidade
     *
     * @return Winner
     */
    public function setDsCidade($dsCidade)
    {
        $this->ds_cidade = $dsCidade;

        return $this;
    }

    /**
     * Get dsCidade
     *
     * @return string
     */
    public function getDsCidade()
    {
        return $this->ds_cidade;
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
            'ds_cidade' => $this->getDsCidade(),
            'id' => $this->getId(),
            'nr_sorteio' => $this->getNrSorteio()
        );
    }
}

