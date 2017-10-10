<?php

namespace SRS\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class PersonController
{
    private $db;
    private $validator;

    public function __construct($entity_manager,$validator)
    {
        $this->db = $entity_manager;
        $this->validator = $validator;
    }

    public function index()
    {
        $payload = $this->db->getRepository('\\SRS\\Entitys\\Person')->findAll();

        $results = array();
        foreach ($payload as $key => $value) {
            $results[] = array(
                "id" => $value->getId(),
                "name" => $value->getName(),
                "email" => $value->getEmail(),
                "document" => $value->getDocument(),
                "phone" => $value->getPhone(),
                "createdAt" => $value->getCreatedAt(),
                "updatedAt" => $value->getUpdatedAt(),
            );
        }

        return new JsonResponse($results, Response::HTTP_OK);
    }

    public function show(Request $request)
    {
        $person = $this->db->getRepository('\\SRS\\Entitys\\Person')
            ->findOneBy(["id" => $request->get('id')]);

        if (!$person) {
            return new JsonResponse(["Error" => 'Person not found!'], Response::HTTP_NOT_FOUND);
        }

        $payload = array(
            "id" => $person->getId(),
            "name" => $person->getName(),
            "email" => $person->getEmail(),
            "document" => $person->getDocument(),
            "phone" => $person->getPhone(),
            "createdAt" => $person->getCreatedAt(),
            "updatedAt" => $person->getUpdatedAt(),
        );

        return new JsonResponse($payload, Response::HTTP_OK);
    }

    public function create(Request $request)
    {
        $payload = json_decode($request->getContent());
        $repository = $this->db;
        $person = new \SRS\Entitys\Person();
        $person->setDocument($payload->document);
        $person->setName($payload->name);
        $person->setEmail($payload->email);
        $person->setPhone($payload->phone);

        $errors = $this->validator->validate($person);

        if (count($errors) > 0) {

            $errorList = array();
            foreach ($errors as $error) {
                $errorList[] = array( $error->getPropertyPath() => $error->getMessage() );
            }

            return new JsonResponse($errorList, Response::HTTP_FOUND);
        }

        $repository->persist($person);
        $repository->flush();

        return new JsonResponse($payload, Response::HTTP_OK);
    }

    public function update(Request $request)
    {
        $payload = json_decode($request->getContent());
        $person = $this->db->getRepository('\\SRS\\Entitys\\Person')
            ->findOneBy(["id" => $request->get('id')]);

        if (!$person) {
            return new JsonResponse(["Error" => 'Person not found!'], Response::HTTP_NOT_FOUND);
        }

        $person->setDocument($payload->document);
        $person->setName($payload->name);
        $person->setEmail($payload->email);
        $person->setPhone($payload->phone);

        $this->db->persist($person);
        $this->db->flush();

        return new JsonResponse($payload, Response::HTTP_OK);
    }

    public function delete(Request $request)
    {
        $payload = json_decode($request->getContent());
        $person = $this->db->getRepository('\\SRS\\Entitys\\Person')
            ->findOneBy(["id" => $request->get('id')]);

        if (!$person) {
            return new JsonResponse(["Error" => 'Person not found!'], Response::HTTP_NOT_FOUND);
        }

        $this->db->remove($person);
        $this->db->flush();

        return new JsonResponse([ "status"=>"Successfully deleted person!"], Response::HTTP_OK);
    }

}