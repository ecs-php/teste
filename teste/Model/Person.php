<?php

namespace TESTE\Model;

use TESTE\Entity\Person as PersonEntity;
use \Exception;

/**
 * Description of Pessoa
 *
 * @author pandacoder
 */
class Person {
    
    protected $app;
            
    function __construct($app) {
        $this->app = $app;
    }
    
    public function getAll()
    {
        $repository = $this->app['orm.em']->getRepository('TESTE\Entity\Person');
        $list = $repository->findAll();
        
        $response = [];
        foreach ($list as $person){
            $response[] =  $person->toArray();
        }
        
        return $response;
    }
    
    public function insert(PersonEntity $person)
    {
        return $this->save($person);
    }
    
    public function update(PersonEntity $person)
    {
        return $this->save($person);
    }
    
    protected function save(PersonEntity $person)
    {
        $this->app['orm.em']->persist($person);
        $this->app['orm.em']->flush();
        
        return $person;
    }

    public function delete(PersonEntity $person)
    {
        if ( $person == NULL){
            throw new Exception("No data found!");
        }
        $this->app['orm.em']->remove($person);
        $this->app['orm.em']->flush();
        
        return $person;
    }
}
