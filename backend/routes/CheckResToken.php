<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Restaurant;

class CheckResToken
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
        $user = Restaurant::where('token', $request->token)->first();
        if (empty($user)) {
            return response()->json(['code' => '3', 'message' => 'Token is wrong!'], 200);
        } else {
            return $next($request);
        }
    }
}