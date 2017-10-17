<?php
namespace Application\Service;
use Zend\Http\PhpEnvironment\Request;

/**
 * Class ServiceJsonPostRequest Serviço responsável por recuperar os posts de form por ajax Caso esteja usando unit
 * de test, recupera da forma normal
 * @package Nucleo\Service
 */
class ServiceJsonPostRequest
{

    private $objRequest;

    /**
     * Recupera o post enviado, ou por ajax ou por post do form
     * @return mixed
     */
    public function getJsonPost()
    {
        // se o php unit está setado, envia valores por post
        if (defined('C_PHPUNIT') == true) {
            return $this->getObjRequest()
                ->getPost()
                ->toArray();
        }

        return json_decode(
            $this->getObjRequest()
                ->getContent(),
            true
        );
    }

    /**
     * Seta o objeto do Controller
     * @param Request $objRequest
     * @return $this
     */
    public function setObjRequest(
        Request $objRequest
    ) {
        $this->objRequest = $objRequest;

        return $this;
    }

    /**
     * Retorna o objeto do request
     * @return Request
     */
    private function getObjRequest()
    {
        return $this->objRequest;
    }

    /**
     * @return bool|string
     */
    public function getParamsLog()
    {
        $sn_existe = $this->getObjRequest();
        if (empty($sn_existe)) {
            return false;
        }
        return $this->getObjRequest()
            ->getContent();
    }
}
