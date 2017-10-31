<?php

namespace Domain;

use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 *
 * @package Domain
 *
 * @property integer id
 * @property string username
 * @property string password
 * @property string key
 */
class User extends Model
{
    /**
     * @var string
     */
    protected $table = 'users';
}