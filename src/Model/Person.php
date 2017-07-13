<?php

namespace App\Model;

class Person extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'person';

    protected $fillable = [
        'name', 'email', 'date_birth', 'address',
    ];
    
}