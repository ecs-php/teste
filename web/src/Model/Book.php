<?php 
namespace Hmarinjr\RESTFulAPI\Model;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'book';

	const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
}
