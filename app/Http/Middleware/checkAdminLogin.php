<?php

namespace App\Http\Middleware;

use Closure;

use App\Http\Controllers\Controller;

class checkAdminLogin
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
//        if (empty($request->session()->get('admin_id'))) {
//            $error_handler = new Controller;
//            $error_handler->errorHandler(303);
//            return null;
//        }
        return $next($request);
    }
}
