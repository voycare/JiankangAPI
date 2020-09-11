<?php

namespace App\Http\Middleware;

use App\Models\Doctor;
use Closure;
use Illuminate\Support\Facades\Auth;

class IsDoctorAuth
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
        if (Auth::user()->role == Doctor::ROLE_DOCTOR) {
            return $next($request);
        } else {
            return response()->json([
                'code' => 401,
                'message' => 'Clinic Permission Denied'
            ], 401);
        }
    }
}
