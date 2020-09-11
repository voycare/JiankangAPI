<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ClinicAvailableHelper;
use App\Http\Requests\ClinicAvaiableStoreRequest;
use App\Http\Resources\ClinicAvailableCollection;
use App\Http\Resources\ClinicAvailableResource;
use App\Models\Clinic;
use App\Models\ClinicAvailable;
use App\Traits\ApiResponser;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ClinicAvailableController extends Controller
{
    use ApiResponser;

    /**
     * @param $id
     * @return ClinicAvailableController
     */
    public function show($id)
    {
        $clinic = Clinic::find($id);
        if (!$clinic) {
            return $this->errorMessage('Clinic Not Found!', 404);
        }

        $now = Carbon::now();
        $clinic_availables = ClinicAvailable::where('clinic_id', $id)->where('date', '>=', $now)->orderBy('date', 'ASC')->get();

        return $this->successResponse(new ClinicAvailableCollection($clinic_availables));
    }

    /**
     * @param $id
     * @param Request $request
     * @return ClinicAvailableController|\Illuminate\Http\JsonResponse
     */
    public function update($id, ClinicAvaiableStoreRequest $request)
    {
        $clinic = Clinic::find($id);
        if (!$clinic) {
            return $this->errorMessage('Clinic Not Found!', 404);
        }

        $record = ClinicAvailableHelper::store($request);

        return $this->successResponseMessage(ClinicAvailableResource::make($record), 200, 'Update Clinic Available Successfully!');
    }

    /**ClinicAvailableResource
     * @param $id
     * @param Request $request
     * @return ClinicAvailableController|\Illuminate\Http\JsonResponse
     */
    public function remove($id, Request $request)
    {
        $clinic = Clinic::find($id);
        if (!$clinic) {
            return $this->errorMessage('Clinic Not Found!', 404);
        }

        ClinicAvailable::where('clinic_id', $id)->where('id', $request->get('id'))->delete();

        return $this->successResponseMessage([], 200, 'Delete Clinic Available successfully!');
    }
}
