<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class IsAdminAuth
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
        if (Auth::user()->role == User::ROLE_ADMIN) {
            return $next($request);
        } else {
            return response()->json([
                'code' => 401,
                'message' => 'Admin Permission Denied'
            ], 401);
        }
    }
}
