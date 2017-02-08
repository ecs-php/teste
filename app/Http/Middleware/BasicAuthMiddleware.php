<?php

namespace App\Http\Middleware;

use Closure;

class BasicAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if($request->getUser() != 'ecs-php' || $request->getPassword() != 'santoscaio') {
            $headers = array('WWW-Authenticate' => 'Basic');
            return response('Authentication required', 401, $headers);
        }
        return $next($request);
    }
}