<?php

namespace App\Http\Controllers\Admin;

use App\Consts;
use App\Http\Resources\DoctorCollection;
use App\Models\Doctor;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DoctorController extends Controller
{
    use ApiResponser;

    /**
     * @return DoctorController
     */
    public function index(Request $request)
    {
        $limit = isset($request->limit) ? $request->limit : Consts::LIMIT_ITEM_PAGE;
        $sortDate = isset($request->sort_created) ? $request->sort_created : 'desc';
        $type = isset($request->type) ? $request->type : '';
        $country = isset($request->country) ? $request->country : '';
        $city = $request->has('city') ? $request->get('city') : '';
        $doctor_name = $request->has('name') ? $request->get('name') : '';
        $treatment_id = $request->has('treatment_id') ? $request->get('treatment_id') : '';

        $query = Doctor::query();
        if ($doctor_name) {
            $query = $query->where('name', 'LIKE', '%' + $doctor_name + '%');
        }
        if ($country) {
            $query = $query->whereHas('clinic', function ($q) use ($country, $city) {
                return $q->whereHas('address', function ($_q) use ($country, $city) {
                    if ($country) {
                        $_q = $_q->where('country', $country);
                    }
                    if ($city) {
                        $_q = $_q->where('city', $city);
                    }

                    return $_q;
                });
            });
        }
        if ($treatment_id) {
            $query = $query->whereHas('clinic', function ($q) use ($treatment_id) {
                return $q->whereHas('treatments', function ($_q) use ($treatment_id) {
                    return $_q->where('id', $treatment_id);
                });
            });
        }
        if ($limit) {
            $query = $query->limit($limit);
        }
        $query = $query->orderBy('created_at', $sortDate);
        $doctors = $query->paginate();

        return $this->successResponse(new DoctorCollection($doctors));
    }

    /**
     * @param $id
     * @return DoctorController|\Illuminate\Http\JsonResponse
     */
    public function remove($id)
    {
        $doctor = Doctor::find($id);
        if (!$doctor) {
            return $this->errorMessage('Doctor not found!', 404);
        }
        $doctor->delete();

        return $this->successResponseMessage([], 200, 'Doctor delete successfull!');
    }
}
