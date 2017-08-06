<?php

namespace App\Models;

class Wine extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'wines';
    protected $fillable = [
        'title', 'body', 'image_url', 'source', 'active',
    ];


    public function user(){
        return $this->belongsTo(User::class)->select(array('id', 'name', 'email'));
    }
}

?>


