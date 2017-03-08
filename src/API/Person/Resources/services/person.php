<?php
/**
 * Created by André Felipe de Souza.
 * Date: 08/03/17 01:45
 */

$api[Person\Services\Controller\PersonController::class] = function () use ($api) {
    return new Person\Services\Controller\PersonController(
        $api[Person\Services\Retrieve\PersonRetrieve::class],
        $api[Person\Services\Persist\PersonPersist::class]
    );
};

$api[Person\Services\Retrieve\PersonRetrieve::class] = function () use ($api) {
    /** @var \Doctrine\ORM\EntityManager $entityManager */
    $entityManager = $api[\Doctrine\ORM\EntityManager::class];

    return new Person\Services\Retrieve\PersonRetrieve(
        $entityManager->getRepository(Person\Entity\Person::class)
    );
};

$api[Person\Services\Persist\PersonPersist::class] = function ($api) {
    /** @var \Doctrine\ORM\EntityManager $entityManager */
    $entityManager = $api[\Doctrine\ORM\EntityManager::class];

    return new Person\Services\Persist\PersonPersist(
        $entityManager
    );
};
