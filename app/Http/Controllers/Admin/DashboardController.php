<?php

namespace App\Http\Controllers\Admin;

use App\Models\Doctor;
use App\Traits\ApiResponser;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    use ApiResponser;

    /**
     * @return DashboardController
     */
    public function totals()
    {
        $doctors = Cache::remember('doctor_total', 5 * 60, function () {
            return number_format(Doctor::count());
        });
        $clients = Cache::remember('client_total', 5 * 60, function () {
            return number_format(User::where('role', User::ROLE_CLIENT)->count());
        });
        $clinics = Cache::remember('clinic_total', 5 * 60, function () {
            return number_format(User::where('role', User::ROLE_CLINIC)->count());
        });
        $revenues = 0;

        return $this->successResponse(compact('doctors', 'clients', 'clinics', 'revenues'));
    }
}
