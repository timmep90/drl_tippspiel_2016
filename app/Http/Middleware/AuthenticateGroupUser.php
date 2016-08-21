<?php

namespace App\Http\Middleware;

use Closure;

class AuthenticateGroupUser
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
        $isUser = $request->user()->user_group->where('group_id',(int)$request->id)->where('pending', 0)->first();

        if ($isUser)
            return $next($request);
        else
            return response('Unauthorized.', 401);
    }
}
