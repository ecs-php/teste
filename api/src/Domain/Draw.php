<?php

namespace Domain;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Draw
 *
 * @package Domain
 *
 * @property mixed date
 * @property integer winner_id
 */
class Draw extends Model
{
    /**
     * @var string
     */
    protected $table = 'draws';
}