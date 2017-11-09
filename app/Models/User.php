<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class User extends Eloquent
{

    protected $table = 'users';


    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [

        'id',
        'name',
        'email',
        'city',
        'phone',
        'code',
        'status'

    ];

    protected $hidden = [

        'password'

    ];

}