<?php

namespace Domain;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Winner
 *
 * @package Domain
 *
 * @property integer id
 * @property string  first_name
 * @property string  last_name
 * @property string  birthday
 * @property mixed   identity
 * @property string  city
 * @property string  state
 */
class Winner extends Model
{
    /**
     * @var string
     */
    protected $table = 'winners';
    /**
     * @var array
     */
    protected $fillable = ['first_name', 'last_name', 'birthday', 'identity', 'city', 'state'];
}