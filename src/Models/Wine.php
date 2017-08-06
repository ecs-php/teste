<?php

namespace App\Models;

class Wine extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'wines';

    protected $fillable = [
        'name', 
        'color', 
        'varietal', 
        'harvest', 
        'region'
    ];
}