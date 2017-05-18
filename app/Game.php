<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'title', 'description', 'release_date', 'price'
	];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $dates = [
    	'deleted_at'
	];
}
