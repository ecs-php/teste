<?php

namespace Infrastructure;

use Symfony\Component\HttpFoundation\Request;

/**
 * Interface BaseRepositoryInterface
 *
 * @package Infrastructure
 */
interface BaseRepositoryInterface
{
    /**
     * @param $id
     *
     * @return mixed
     */
    public function find($id);

    /**
     * @return mixed
     */
    public function findAll();

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function create(Request $request);

    /**
     * @param Request $request
     * @param         $model
     *
     * @return mixed
     */
    public function update(Request $request, $model);

    /**
     * @param $id
     *
     * @return mixed
     */
    public function delete($id);
}