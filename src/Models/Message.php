<?php
namespace App\Models;
/**
 * Created by PhpStorm.
 * User: mauricioschmitz
 * Date: 6/5/17
 * Time: 21:02
 */
Class Message extends \Illuminate\Database\Eloquent\Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'body', 'image_url', 'source', 'active',
    ];


    public function user(){
        return $this->belongsTo(User::class)->select(array('id', 'name', 'email'));
    }
}

?>


