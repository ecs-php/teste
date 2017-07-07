<?php
/**
 * Created by PhpStorm.
 * User: mauricioschmitz
 * Date: 6/5/17
 * Time: 21:06
 */
namespace App\Models;

class User extends \Illuminate\Database\Eloquent\Model
{
    public function authenticate($apikey)
    {
        $user = User::where('apikey', '=', $apikey)->take(1)->get();
        
        
        if(isset($user[0])){
            $this->details = $user[0];
            return $this->details->id;

        }
        return false;
    }

    public function message()
    {
        return $this->hasMany(Message::class);
    }
}