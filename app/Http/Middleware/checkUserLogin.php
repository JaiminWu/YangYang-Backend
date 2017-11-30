<?php

namespace App\Http\Middleware;

use Closure;

use App\Http\Controllers\Controller;

class checkUserLogin
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
        if (empty($request->session()->get('user_id'))) {
            $error_handler = new Controller;
            $error_handler->errorHandler(303);
            return true;
        }
        return $next($request);
    }
}
