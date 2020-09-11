<?php
/**
 * Created by PhpStorm.
 * User: dinhln
 * Date: 8/12/20
 * Time: 09:01
 */

namespace App\Helpers;

use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AppointmentHelper
{
    /**
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function index(Request $request)
    {
        $sortDate = $request->has('sort_created') ? $request->get('sort_created') : 'desc';
        $country = $request->has('country') ? $request->get('country') : '';
        $query = Appointment::query();
        if ($country) {
            $query = $query->whereHas('client', function ($q) use ($country) {
                return $q->where('country', $country);
            });
        }
        if ($request->has('type_ids')) {
            $query = $query->whereIn('type_id', $request->get('type_ids'));
        }
        if ($request->has('status_ids')) {
            $query = $query->whereIn('status', $request->get('status_ids'));
        }
        if ($request->has('status')) {
            $query = $query->where('status', $request->get('status'));
        }
        if ($request->has('specialty_id')) {
            $query = $query->where('specialty_id', $request->get('specialty_id'));
        }
        if ($request->has('treatment_id')) {
            $query = $query->where('treatment_id', $request->get('treatment_id'));
        }
        if ($request->has('interpreter_id')) {
            $query = $query->where('interpreter_id', $request->get('interpreter_id'));
        }
        if ($request->has('from') && $request->has('to')) {
            $from = Carbon::createFromTimestamp($request->get('from'));
            $to = Carbon::createFromTimestamp($request->get('to'));
            $query = $query->where('created_at', '>=', $from)->where('created_at', '<=', $to);
        }
        $query = $query->orderBy('created_at', $sortDate);

        return $query;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public static function totals(Request $request)
    {
        $query = Appointment::query();
        if ($request->has('from') && $request->has('to')) {
            $from = Carbon::createFromTimestamp($request->get('from'));
            $to = Carbon::createFromTimestamp($request->get('to'));
            $query = $query->where('created_at', '>=', $from)->where('created_at', '<=', $to);
        }
        if ($request->has('status_ids')) {
            $query = $query->whereIn('status', $request->get('status_ids'));
        }
        if ($request->has('type_ids')) {
            $query = $query->whereIn('type_id', $request->get('type_ids'));
        }
        return $query->payments()->sum('paid_amount');
    }
}