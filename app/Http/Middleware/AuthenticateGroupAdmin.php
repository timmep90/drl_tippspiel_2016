<?php

namespace App\Http\Middleware;

use Closure;

class AuthenticateGroupAdmin
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
        $isUser = $request->user()->group_user->where('group_id',(int)$request->id)->first();
        $isUser ?$isAdmin = $request->user()->group_user->where('group_id',(int)$request->id)->first()->isAdmin
            :$isAdmin = false;

        if ($isAdmin)
            return $next($request);
        else
            return response('Unauthorized.', 401);
    }
}
