<?php

namespace TESTE\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use TESTE\Model\Person as PersonModel;
use TESTE\Entity\Person as PersonEntity;
use \Exception;

/**
 * Description of Pessoa
 *
 * @author pandacoder
 */
class Person {
    
    protected $app;
    protected $personModel;
            
    function __construct(Application $app) {
        $this->app = $app;
        $this->personModel = new PersonModel($app);
    }
    
    public function listAction( Request $request)
    {
       return $this->personModel->getAll();
    }
    
    public function insertAction(Request $request)
    {
        $person = new PersonEntity();
        
        $person->setName($request->request->get('name'));
        $person->setPhone($request->request->get('phone'));
        $person->setEmail($request->request->get('email'));
        $person->setFacebook($request->request->get('facebook'));
        $person->setTwitter($request->request->get('twitter'));
        
        
        $person = $this->personModel->insert($person);
                
        return $person->toArray();
    }
    
    public function updateAction(Request $request)
    {        
        if ( empty($request->request->get('id'))){
            throw new Exception("You must send id to update!");
        }
       $repository = $this->app['orm.em']->getRepository('TESTE\Entity\Person');
        $person = $repository->find($request->request->get('id'));
       
        if ( !empty($request->request->get('name'))){
            $person->setName($request->request->get('name'));
        }
        if ( !empty($request->request->get('phone'))){
            $person->setPhone($request->request->get('phone'));
        }
        if ( !empty($request->request->get('email'))){
            $person->setEmail($request->request->get('email'));
        }
        if ( !empty($request->request->get('facebook'))){
            $person->setFacebook($request->request->get('facebook'));
        }
        if ( !empty($request->request->get('twitter'))){
            $person->setTwitter($request->request->get('twitter'));
        }
        
       
        $person->setUpdated();
        
        $person = $this->personModel->update($person);
                
        return $person->toArray();
    }
    
    public function deleteAction(Request $request)
    {
        if ( empty($request->request->get('id'))){
            throw new Exception("You must send id to delete!");
        }
        
        $repository = $this->app['orm.em']->getRepository('TESTE\Entity\Person');
        $person = $repository->find($request->request->get('id'));
         if ( $person == NULL){
            throw new Exception("No data found!");
        }
        $person = $this->personModel->delete($person);
                
        return $person->toArray();
    }
}
