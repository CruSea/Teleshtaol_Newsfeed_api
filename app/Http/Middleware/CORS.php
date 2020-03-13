<?php

namespace App\Http\Middleware;

use Closure;

class CORS
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
      */
     /*public function handle($request, Closure $next)
    {
         header('Access-Control-Allow-Origin : *');
        header('Access-Control-Allow-Headers : Content-type, X-Auth-Token, Authorization, Origin');
        header('Access-Control-Allow-Headers','X-Requested-With,XMLHttpRequest');
        /return $next($request); 
        return $next($request)
        ->header('Access-Control-Allow-Origin','*')
        ->header('Access-Control-Allow-Methods','GET,POST,PUT,PATCH,DELETE,OPTIONS')
        ->header('Access-Control-Allow-Headers','Origin,Content-Type,X-Auth-Token,Authorization')
        ->header('Access-Control-Allow-Headers','X-Requested-With,XMLHttpRequest')
        ->header('Access-Control-Allow-Headers','Content-Type,x-xsrf-token,X-Auth-Token');
    }  */
    public function handle($request, Closure $next)
    {

         return $next($request)
        ->header('Access-Control-Allow-Origin','*')
        ->header('Access-Control-Allow-Methods','GET, POST, PUT, PATCH, DELETE, OPTIONS')
        ->header('Access-Control-Allow-Headers','Content-Type,Authorization,X-Auth-Token,Origin,x-xsrf-token'); 
       /*  return $next($request)
        ->header('Access-Control-Allow-Origin','*') 
        ->header('Access-Control-Allow-Methods','GET,POST,PUT,PATCH,DELETE,OPTIONS')
        ->header('Access-Control-Allow-Headers','Content-Type,Authorization')
        ->header('Access-Control-Allow-Headers','Content-Type,x-xsrf-token');  */  
    }
}
