<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $permission): Response
    {
        if(!auth()->user()->hasPermission($permission)){
            //O usuário não tem a permissão necessária, redirecione ou aborte...
            abort(401);
        }
        
        return $next($request);
    }
}
