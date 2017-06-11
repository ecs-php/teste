<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Input;
class AuthBasic
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $token = Input::get('app_token');

        if(empty($token)){
            return response()->json([
                'success'=>false,
                'message'=>'Provide a valid application token.'
            ]);
        }

        $tokens = config('tokens.keys');

        if(!in_array($token,$tokens)){
            return response()->json([
                'success'=>false,
                'message'=>'Invalid token.'
            ]);
        }

        return $next($request);

    }
}
