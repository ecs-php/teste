<?php

/**
 * Classe responsavél pela gestão da api
 */
namespace Api\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Application\Controller\AbstractController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class ApiController extends AbstractController
{

    private $token;


    /**
     * Metodo responsável por carregar os dados de sorteados, sorteios e data para o próximo sorteio.
     * @return array com os vencedores dos sorteios anteriores, próximos sorteios e sorteio atual.
     */
    public function indexAction()
    {
        //Load winners
        $objRepositorio = $this->getRepository(\Api\Entidade\Winner::class)->findAll();
        $arrWinners = [];
        foreach($objRepositorio as $objWinner){
            $arrWinners[] = $objWinner->toArray();
        };





        //Load lottery
        $objRepositorio = $this->getRepository(\Api\Entidade\Lottery::class)->findAll();
        $arrLottery = [];
        foreach($objRepositorio as $objLottery){
            $arrLottery[] = $objLottery->toArray();
        };


        $arrRet['current_lottery'] = date('d/y');
        $arrRet['arrWinners'] = $arrWinners;
        $arrRet['arrLottery'] = $arrLottery;

        return new JsonModel($arrRet);
    }






}
