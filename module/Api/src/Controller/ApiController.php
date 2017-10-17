<?php

/**
 * Classe responsavél pela gestão da api
 */
namespace Api\Controller;

use Application\Controller\AbstractController;
use Zend\View\Model\JsonModel;

class ApiController extends AbstractController {

    private $token;

    /**
     * Metodo responsável por carregar os dados de sorteados, sorteios e data para o próximo sorteio.
     * @return array com os vencedores dos sorteios anteriores, próximos sorteios e sorteio atual.
     */
    public function indexAction() {

        try {

            //Load winners
            $objRepositorio = $this->getRepository(\Api\Entidade\Winner::class)
                ->findBy(
                    array(), 
                    array('dt_sorteio' => 'ASC')
            );
            $arrWinners = [];
            foreach ($objRepositorio as $objWinner) {
                $arrWinners[] = $objWinner->toArray();
            };

            //Load lottery
            $objRepositorio = $this->getRepository(\Api\Entidade\Lottery::class)
            ->findBy(
                    array(), 
                    array('dt_sorteio' => 'ASC')
            );
            $arrLottery = [];
            foreach ($objRepositorio as $objLottery) {
                $arrLottery[] = $objLottery->toArray();
            };

            $arrRet['current_lottery'] = date('d/y');
            $arrRet['arrWinners'] = $arrWinners;
            $arrRet['arrLottery'] = $arrLottery;
            $arrRet['sn_status'] = true;
            $arrRet['ds_mensagem'] = null;

        } catch (\Exception $objException) {

            $arrRet['sn_status'] = false;
            $arrRet['ds_mensagem'] = $objException->getMessage();

        }

        return new JsonModel($arrRet);
    }

    /**
     * Metodo responsavel por verificar se o header esta correto
     */
    public function autenticarAction() {
        //Verificar o cabeçalho
        $ds_mensagem = 'ok';
        $sn_status = true;
        $ds_hash = null;
        try {

            $this->_autenticar();

        } catch (\Exception $objException) {
            $sn_status = false;
            $ds_mensagem = $objException->getMessage();
            $this->getResponse()->setStatusCode(401);

        }

        return new JsonModel(
            array(
                'sn_status' => $sn_status,
                'ds_mensagem' => $ds_mensagem,
            )
        );

    }

    /**
     * Metodo responsável por salvar um novo cadastro no banco de dados
     */
    public function saveAction(){

    }




    /**
     * Realizar a autenticação de uma solicitação, verificar se o cabeçalho
     * com o token está preenchido, se estiver então verificar se é um token válido
     */
    private function _autenticar() {
        try {


            $this->verificarCabecalho();
            $this->logar($arrDados);


        } catch (\Exception $objException) {

            $this->getResponse()->setStatusCode(401);

            throw new \Exception($objException->getMessage(), 1);

        }

        return true;

    }

    /**
     * Verificar se o token de cabeçalho foi preenchido
     */
    private function verificarCabecalho() {

        try {

            $headers = $this->getRequest()->getHeaders();
            $objToken = $headers->get('token');

            if (empty($objToken)) {
                throw new \Exception("Token not null", 401);
            }
            $ds_token = $objToken->getFieldValue();

            $this->setToken($ds_token);

        } catch (\Exception $objException) {

            throw new \Exception($objException->getMessage(), 401);
        }

    }


    /**
     * Verificar se o token é um token válido
     * (Poderia ser uma verificação no banco de dados, fiz apenas uma validação direta para simplificar)
     */
    private function logar($arrPost) {
        try {

            $ds_token = $this->getToken();

            if ($ds_token != 'MEUTOKEN') {

                throw new \Exception('token inválido', 401);

            }

        } catch (\Exception $objException) {

            throw new \Exception($objException->getMessage(), 401);

        }
        return true;
    }


    private function getToken() {
        return $this->token;
    }
    private function setToken($ds_token) {
        $this->token = $ds_token;

        return $this;
    }

}
