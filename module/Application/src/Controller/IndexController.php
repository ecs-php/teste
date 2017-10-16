<?php
namespace Application\Controller;

use Application\Controller\AbstractController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractController {
    /**
     * Tela inicial e publica do sistema
     */
    public function indexAction() {


        return new ViewModel();
    }


}
