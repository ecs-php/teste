<?php

/**
 * Created by André Felipe de Souza.
 * Date: 08/03/17 01:46
 */

namespace Person\Services\Controller;

use Common\Services\Controller\AbstractController;
use Doctrine\Common\Collections\ArrayCollection;
use Person\Entity\Person;
use Person\Services\Persist\PersonPersist;
use Person\Services\Retrieve\PersonRetrieve;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class PersonController
 * @package Person\Services\Responder
 */
class PersonController extends AbstractController
{
    /**
     * @var PersonRetrieve
     */
    private $personRetrieve;

    /**
     * @var PersonPersist
     */
    private $personPersist;

    /**
     * PersonController constructor.
     * @param PersonRetrieve $personRetrieve
     * @param PersonPersist $personPersist
     */
    public function __construct(
        PersonRetrieve $personRetrieve,
        PersonPersist $personPersist
    ) {
        $this->personRetrieve = $personRetrieve;
        $this->personPersist = $personPersist;
    }

    /**
     * @return JsonResponse
     */
    public function get()
    {
        /** @var ArrayCollection|Person $personFromDB */
        $personFromDB = $this->personRetrieve->retrieveAll();

        $return = [];

        foreach ($personFromDB as $person) {
            $return[] = $person->toArray();
        }

        return $this->createResponse($return);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function getById(Request $request)
    {
        return $this->createResponse(($this->getPersonById($request->get('id')))->toArray());
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function post(Request $request)
    {
        /** @var \stdClass $data */
        $data = $this->getJsonParameters($request);
        return $this->createResponse(($this->personPersist->processCreate($data))->toArray());
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function put(Request $request)
    {
        /** @var \stdClass $data */
        $data = $this->getJsonParameters($request);

        return $this->createResponse(
            ($this->personPersist->processUpdate($data, $this->getPersonById($data->id ?? null)))->toArray()
        );
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function delete(Request $request)
    {
        return $this->createResponse(
            ($this->personPersist->processDelete($this->getPersonById($request->get('id'))))->toArray()
        );
    }

    /**
     * @param string|null $id
     * @return null|Person
     * @throws \Exception
     */
    private function getPersonById(string $id = null)
    {
        /** @var Person|null $personFromDB */
        $personFromDB = $this->personRetrieve->retrieveById($id);

        if (!$personFromDB instanceof Person) {
            throw new \Exception('Person not found with id: ' . $id);
        }

        return $personFromDB;
    }
}
