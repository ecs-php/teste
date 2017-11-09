<?php 
namespace Hmarinjr\RESTFulAPI\Model;
 
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'client';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    /**
     * @param string $apikey
     * @return int ID of client or false
    */
    public function authenticate($apikey)
    {
        if (!$apikey || !$apikey = base64_decode($apikey))  {
          return false;
        }

        $userPass = explode(':', $apikey);
        $user = Client::where('user', $userPass[0])->take(1)->get();

        if (isset($user[0]) && $user[0]->pass == hash('sha256', $userPass[1])) { 
            $this->details = $user[0];
            return $this->details->id;
        }

       	return false;
   	}
}