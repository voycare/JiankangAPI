<?php

namespace App\Http\Controllers\Clinic;

use App\Models\Review;
use App\Traits\ApiResponser;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    use ApiResponser;

    /**
     * @return DashboardController
     */
    public function totals()
    {
        $clients = Cache::remember('client_total', 5 * 60, function () {
            return number_format(User::where('role', User::ROLE_CLIENT)->count());
        });
        $ratings = Cache::remember('rating_total', 5 * 60, function () {
            return number_format(Review::where('clinic_id', Auth::id())->count());
        });

        return $this->successResponse(compact('clients', 'ratings'));
    }
}
