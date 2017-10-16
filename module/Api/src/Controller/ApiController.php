<?php
/**
 * @link      http://github.com/zendframework/Api for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Api\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class ApiController extends AbstractActionController
{
    private const DS_ERRO_CLIENTE_N_ENCONTRADO = "Cliente não encontrado";
    private const DS_KEY_CLIENTE_N_ENCONTRADO = 'cliente-n-encontrato';
    private $token;

    public function indexAction()
    {

        return [];
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

            $this->verificarCabecalho();

            $arrDados = $this->getArrPost();

            $ds_hash = $this->logar($arrDados);

        } catch (\Exception $objException) {
            $sn_status = false;
            $ds_mensagem = $objException->getMessage();
            $this->getResponse()->setStatusCode(401);

        }



        return new JsonModel(
            array(
                'sn_status' => $sn_status,
                'ds_mensagem' => $ds_mensagem,
                'ds_sessao' => $ds_hash,
            )
        );

    }

    /**
     * Verificar o cliente logado
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

    //Validar token do usuário
    private function logar($arrPost) {
        try {

            $ds_token = $this->getToken();
            // acessa como usuario do cliente
            $this->AutenticarCliente();



        } catch (\Exception $objException) {

            throw new \Exception($objException->getMessage(), 401);

        }
        return $ds_hash;

    }

    /**
     * Verificar se o token é valido.
     */
    private function AutenticarCliente() {
        try {

            $ds_token = $this->getToken();

            //Buscar token no database

            // o cliente não existe
            if (empty($objSaasCliente)) {
                throw new \Exception('Token do cliente inválido', 401);
            }


        } catch (\Exception $objException) {

            throw new \Exception($objException->getMessage(), 401);
        }

        return $ds_token;
    }


    private function getToken() {
        return $this->token;
    }

    private function setToken($ds_token) {
        $this->token = $ds_token;

        return $this;
    }


}
