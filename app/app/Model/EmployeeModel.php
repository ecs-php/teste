<?php

namespace app\Model;

use Illuminate\Database\Eloquent\Model;

class EmployeeModel extends Model
{
   protected $table = 'employee';

   protected $fillable = [
                           'name',
                           'email',
                           'address',
                           'number',
                           'phone',
                           'cpf'
                           ];
}
