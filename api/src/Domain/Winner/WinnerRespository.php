<?php

namespace Domain\Winner;

use Domain\Winner;
use Infrastructure\BaseRepository;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class WinnerRespository
 *
 * @package Domain\Winner
 */
class WinnerRespository extends BaseRepository
{
    /**
     * @var Winner
     */
    protected $model;

    /**
     * WinnerRespository constructor.
     *
     * @param Winner $model
     */
    public function __construct(Winner $model)
    {
        $this->model = $model;
    }

    /**
     * @param Request $request
     *
     * @return array|bool
     */
    public function hasErrors(Request $request)
    {
        $errors = [];
        if (!$request->request->has('first_name')) {
            $errors[] = 'first_name is mandatory';
        }
        if ($request->request->has('first_name') && $request->request->get('first_name') == null) {
            $errors[] = 'first_name cannot be null';
        }
        if ($request->request->has('first_name') && strlen($request->request->get('first_name')) > 64) {
            $errors[] = 'first_name max size 64 chars';
        }
        if (!$request->request->has('last_name')) {
            $errors[] = 'last_name is mandatory';
        }
        if ($request->request->has('last_name') && $request->request->get('last_name') == null) {
            $errors[] = 'last_name cannot be null';
        }
        if ($request->request->has('last_name') && strlen($request->request->get('last_name')) > 64) {
            $errors[] = 'last_name max size 64 chars';
        }
        if (!$request->request->has('birthday')) {
            $errors[] = 'birthday is mandatory';
        }
        if ($request->request->has('birthday') && $request->request->get('birthday')) {
            if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",
                $request->request->get('birthday'))) {
                $errors[] = 'birthday incorrect date format, must be YYYY-MM-DD';
            }
        }
        if ($request->request->has('birthday') && $request->request->get('birthday') == null) {
            $errors[] = 'birthday cannot be null';
        }
        if (!$request->request->has('identity')) {
            $errors[] = 'identity is mandatory';
        }
        if ($request->request->has('identity') && strlen($request->request->get('identity')) > 64) {
            $errors[] = 'identity max size 9 chars';
        }
        if ($request->request->has('identity') && $request->request->get('identity') == null) {
            $errors[] = 'identity max size 64 chars';
        }
        if (!$request->request->has('city')) {
            $errors[] = 'city is mandatory';
        }
        if ($request->request->has('city') && strlen($request->request->get('city')) > 64) {
            $errors[] = 'city max size 64 chars';
        }
        if ($request->request->has('city') && $request->request->get('city') == null) {
            $errors[] = 'city cannot be null';
        }
        if (!$request->request->has('state')) {
            $errors[] = 'state is mandatory';
        }
        if ($request->request->has('state') && strlen($request->request->get('state')) > 2) {
            $errors[] = 'state max size 9 chars';
        }
        if ($request->request->has('state') && $request->request->get('state') == null) {
            $errors[] = 'state cannot be null';
        }
        if ($errors) {
            return ['errors' => $errors];
        }

        return false;
    }

    /**
     * @param Request $request
     *
     * @return Winner
     */
    public function create(Request $request)
    {
        $winner = new Winner();
        $winner->first_name = $request->request->get('first_name', null);
        $winner->last_name = $request->request->get('last_name', null);
        $winner->birthday = $request->request->get('birthday', null);
        $winner->identity = $request->request->get('identity', null);
        $winner->city = $request->request->get('city', null);
        $winner->state = $request->request->get('state', null);
        $winner->save();

        return $winner;
    }

    /**
     * @param Request $request
     * @param Winner $winner
     *
     * @return mixed
     */
    public function update(Request $request, $winner)
    {
        if ($request->request->has('first_name')) {
            $winner->first_name = $request->request->get('first_name');
        }
        if ($request->request->has('last_name')) {
            $winner->last_name = $request->request->get('last_name');
        }
        if ($request->request->has('birthday')) {
            $winner->birthday = $request->request->get('birthday');
        }
        if ($request->request->has('identity')) {
            $winner->identity = $request->request->get('identity');
        }
        if ($request->request->has('city')) {
            $winner->city = $request->request->get('city');
        }
        if ($request->request->has('state')) {
            $winner->state = $request->request->get('state');
        }
        $winner->save();

        return $winner;
    }
}