<?php

namespace Rest\Controllers;

use Domain\Draw\DrawnRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DrawsController
 *
 * @package Rest\Controllers
 */
class DrawsController
{
    /**
     * @var DrawnRepository
     */
    private $drawnRepository;

    /**
     * DrawsController constructor.
     *
     * @param DrawnRepository $drawnRepository
     */
    public function __construct(DrawnRepository $drawnRepository)
    {
        $this->drawnRepository = $drawnRepository;
    }

    /**
     * @return JsonResponse
     */
    public function list()
    {
        return new JsonResponse($this->drawnRepository->findAll(), 200);
    }

    /**
     * @param $id
     *
     * @return JsonResponse
     */
    public function find($id)
    {
        $draw = $this->drawnRepository->find($id);
        if (!$draw) {
            return new JsonResponse(array('message' => 'The item does not exist'), 404);
        }
        return new JsonResponse($draw, 200);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function save(Request $request)
    {
        if($this->drawnRepository->hasErrors($request)){
            return new JsonResponse($this->drawnRepository->hasErrors($request), 400);
        }
        return new JsonResponse($this->drawnRepository->create($request), 201);
    }

    /**
     * @param Request $request
     * @param         $id
     *
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $draw = $this->drawnRepository->find($id);
        if (!$draw) {
            return new JsonResponse(array('message' => 'The item does not exist'), 404);
        }
        if($this->drawnRepository->hasErrors($request)){
            return new JsonResponse($this->drawnRepository->hasErrors($request), 400);
        }

        return new JsonResponse($this->drawnRepository->update($request, $draw), 204);
    }

    /**
     * @param $id
     *
     * @return JsonResponse
     */
    public function delete($id)
    {
        $draw = $this->drawnRepository->find($id);
        if (!$draw) {
            return new JsonResponse(array('message' => 'The item does not exist'), 404);
        }
        return new JsonResponse($this->drawnRepository->delete($id), 204);
    }
}