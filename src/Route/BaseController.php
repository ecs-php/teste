<?php



$base = $app['controllers_factory'];



$base->get('/', function () use ($entityManager) {

//    $user = new \Entity\User();
//    $user->setLogin("Loko de droga");
//    $user->setPassword("loko");
//
//    $em->persist($user);
//    $em->flush();
//    $dados =$entityManager->getRepository("Entity\User")->findUser('osmar');
    
//    dump($app['db']['event_manager']->persist($user));
//    dump($dados );
    
    return false;
});

return $base;
