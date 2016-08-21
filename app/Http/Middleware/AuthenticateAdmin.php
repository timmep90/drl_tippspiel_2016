<?php

namespace App\Http\Middleware;

use Closure;

class AuthenticateAdmin
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


        $user = $request->user();

        if ($user && $user->user_type_id == 1)
            return $next($request);
        else
            return response('Unauthorized.', 401);

    }
}
