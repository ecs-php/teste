<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class DrawDate extends Eloquent
{

    protected $table = 'draw_dates';

    protected $dates = ['date'];

    protected $dateFormat = 'd/m';

    protected $fillable = [

        'id',
        'date'
    ];
    

}