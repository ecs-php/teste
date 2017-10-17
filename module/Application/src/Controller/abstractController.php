<?php
namespace Application\Controller;
use Zend\Mvc\Controller\AbstractActionController;
/**
 * Class AbstractIntegracao
 * @package Integracao\Api
 */
abstract class AbstractController extends AbstractActionController {

    /**
     * Retornar o serviceMananger
     */
    public function getServices() {
        return $this->getEvent()
            ->getApplication()
            ->getServiceManager();
    }
    /**
     * Retornar o serviço do doctrine
     */
    public function getServiceDoctrine() {
        return $this->getServices()
            ->get(\Application\Service\ServiceDoctrine::class);
    }

    /**
     * Retornar um repositório
     */
    public function getRepository($ds_repositorio) {
        return $this->getServiceDoctrine()
            ->getRepository($ds_repositorio);
    }


    /**
     * Retorna o post em array
     */
    protected function getArrPost()
    {
        return $this->getServices()
            ->get(\Application\Service\ServiceJsonPostRequest::class)
            ->setObjRequest(
                $this->getRequest()
            )
            ->getJsonPost();
    }

}