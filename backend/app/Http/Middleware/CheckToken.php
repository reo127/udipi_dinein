<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Users;

class CheckToken
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
        $user = Users::where('token', $request->token)->first();
        if (empty($user)) {
            return response()->json(['code' => '3', 'message' => 'Token is wrong!'], 200);
        } else {
            return $next($request);
        }
    }
}