<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SubscriptionCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->subscription){
            if($request->subscription_level == "silver") {
                
            }
            if($request->subscription_level == "gold") {

            }
            if($request->subscription_level == "platinum") {

            }
        }
        return $next($request);
    }
}
