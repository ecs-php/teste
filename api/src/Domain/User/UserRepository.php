<?php

namespace Domain\User;

use Domain\User;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class UserRepository
 *
 * @package Domain\User
 */
class UserRepository
{
    /**
     * @var User
     */
    protected $user;

    /**
     * UserRepository constructor.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function find($id)
    {
        return $this->user->find($id);
    }

    public function authenticate(Request $request)
    {
        if($request->headers->has("Authorization") && $this->user->where('key', $request->headers->get("Authorization"))->first()){
            return true;
        }
        return false;


    }
}