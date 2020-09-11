<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ClinicHelper;
use App\Http\Requests\ClinicServiceRequest;
use App\Http\Resources\ClinicResource;
use App\Models\Clinic;
use App\Models\ClinicService;
use App\Models\ClinicTreatment;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClinicServiceController extends Controller
{
    use ApiResponser;

    /**
     * @param $id
     * @return ClinicServiceController
     */
    public function show($id)
    {
        $clinic = Clinic::find($id);
        if (!$clinic) {
            return $this->errorMessage('Clinic Not Found!', 404);
        }

        return $this->successResponse(ClinicResource::make($clinic));
    }

    /**
     * @param $id
     * @param Request $request
     */
    public function update($id, ClinicServiceRequest $request)
    {
        $clinic = Clinic::find($id);
        if (!$clinic) {
            return $this->errorMessage('Clinic Not Found!', 404);
        }

        $clinic = ClinicHelper::updateServices($clinic->id, $request);

        return $this->successResponseMessage(ClinicResource::make($clinic), 200, 'Update Clinic Service Successfully!');
    }
}
