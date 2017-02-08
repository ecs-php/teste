<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class Contacts extends Model {

    protected $table = 'contact';
    public $incrementing = false;
    public $primaryKey = 'id_contact';
    protected $dates = ['created_at'];

}
