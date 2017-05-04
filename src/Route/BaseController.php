<?php



$base = $app['controllers_factory'];



$base->get('/', function () use ($em) {

    $user = new \Entity\User();
    $user->setLogin("Loko de droga");
    $user->setPassword("loko");

    $em->persist($user);
    $em->flush();
    
//    dump($app['db']['event_manager']->persist($user));
//    dump( );
    
    return false;
});

return $base;
