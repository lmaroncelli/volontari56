<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ForbiddenIfRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        $user = Auth::user();

        if($user && !is_null($role) && $user->ruolo == $role)
          {
          return redirect()->route('home')->with('status', 'Non hai i permessi !!');
          }
          else 
          {
          return $next($request);
          }
    }
}
