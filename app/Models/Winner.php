<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Winner extends Eloquent
{

    protected $table = 'winners';



    protected $fillable = [

        'id',
        'user_id',
        'draw_date_id',

    ];

    public function user()
    {

        return $this->belongsTo('App\Models\User');
    }

    public function drawDate()
    {

        return $this->belongsTo('App\Models\DrawDate');
    }


}