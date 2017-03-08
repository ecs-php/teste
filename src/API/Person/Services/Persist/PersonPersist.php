<?php

/**
 * Created by André Felipe de Souza.
 * Date: 08/03/17 02:42
 */

namespace Person\Services\Persist;

use \Common\Services\Persist\AbstractPersist;
use Person\Entity\Person;

/**
 * Class PersonPersist
 * @package Person\Services\Persist
 */
class PersonPersist extends AbstractPersist
{
    /**
     * @param \stdClass $data
     * @return \Common\Entity\Abstraction\AbstractEntity|Person
     * @throws \Exception
     */
    public function processCreate(\stdClass $data)
    {
        $person = new Person((array) $data);

        $this->entityManager->transactional(function () use ($data, $person) {
            $this->create($person);
        });

        return $person;
    }

    /**
     * @param \stdClass $data
     * @param Person $person
     * @return Person
     */
    public function processUpdate(\stdClass $data, Person $person)
    {
        $person->hydrate((array) $data);

        $this->entityManager->transactional(function () use ($data, $person) {
            $this->update($person);
        });

        return $person;
    }

    /**
     * @param Person $person
     * @return Person
     */
    public function processDelete(Person $person)
    {
        $this->entityManager->transactional(function () use ($person) {
            $this->delete($person);
        });

        return $person;
    }
}
