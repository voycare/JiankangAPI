<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class IsProviderAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::user()->role == User::ROLE_CLINIC) {
            return $next($request);
        } else {
            return response()->json([
                'code' => 401,
                'message' => 'Clinic Permission Denied'
            ], 401);
        }
    }
}
